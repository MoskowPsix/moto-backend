<?php

namespace App\Services;

use App\Contracts\Services\GoogleSheetServiceContract;
use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\Permission;
use Google\Service\Exception;
use Google\Service\Sheets;
use Google\Service\Sheets\Sheet;
use Google\Service\Sheets\Spreadsheet;
use Google\Service\Sheets\ValueRange;
use Google\Service\Transcoder\SpriteSheet;
use Revolution\Google\Sheets\Traits\GoogleSheets;

class GoogleSheetService implements GoogleSheetServiceContract
{
    public string $table_name;

    private string $sheetNameUsers = 'Sheet1';
    public string $url;

    public string $sourceIdSheet = "1t3WuY3wiyCxTU52krYmBdOWcZtm9OcdPIkoLgiwIzcM";

    public array $fields;

    public array $values;
    private Client $client;

    /**
     * @throws Exception
     */
    public function create(string $table_name, array $fields = [], array $value = []): object
    {
        $this->ClientAuth();
        $this->fields = $fields;
        $this->values = $value;
        $this->table_name = $table_name;


        $table = $this->copySheets($this->sourceIdSheet);
        $this->updateRows($table);

        $this->addAccess($table);

        $spriteSheetID = $table->spreadsheetId;

        $url = "https://docs.google.com/spreadsheets/d/$spriteSheetID";
        return (object)['url' => $url, 'sheetID' => $spriteSheetID];
    }

    /**
     * @throws Exception
     */
    public function update(string $id, array $fields = [], array $value = []): object
    {
        $this->ClientAuth();
        $table = $this->getTableForId($id);
        $this->fields = $fields;
        $this->values = $value;
//        $this->addAccess($table);
        $this->updateRows($table);
        $url = "https://docs.google.com/spreadsheets/d/$id";
        $spriteSheetID = $table->spreadsheetId;
        return (object)['url' => $url, 'sheetID' => $spriteSheetID];
    }

    private function ClientAuth(): void
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('credentials.json'));
        $client->setScopes([Sheets::DRIVE, 'https://www.googleapis.com/auth/spreadsheets', Sheets::SPREADSHEETS]);
        $client->setAccessType('online');
        $this->client = $client;
    }

    private function createTable(string $table_name): Spreadsheet
    {
        $service = new Sheets($this->client);
        $spreadSheet = (new Spreadsheet([
            'properties' => [
                'title' => $table_name,
            ],
            ]));
        return $service->spreadsheets->create($spreadSheet);
    }

    private function getTableForId(string $id): Spreadsheet
    {
        $service = new Sheets($this->client);
        return $service->spreadsheets->get($id);
    }

    private function addAccess(Spreadsheet $table): void
    {
        $driveService = new Drive($this->client);
        $driveService->permissions->create($table->spreadsheetId, new Permission([
            'type' => 'anyone',
            'role' => 'writer', // или 'reader', в зависимости от нужного уровня доступа
        ]), ['sendNotificationEmail' => false]);
    }

    /**
     * @throws Exception
     */

    private function addRows(Spreadsheet $table): void
    {
        $service = new Sheets($this->client);

        $bodyTable = new \Google_Service_Sheets_ValueRange([
            'values' => $this->createValuesForTable(),
        ]);

        $range = 'список';
        $service->spreadsheets_values->append(
            $table->spreadsheetId,
            $range,
            $bodyTable,
            ['valueInputOption' => 'RAW']
        );
    }
    private function updateRows(Spreadsheet $table): void
    {
        $service = new Sheets($this->client);

        $bodyTableNew = new \Google_Service_Sheets_ValueRange([
            'values' => $this->createValuesForTable(),
        ]);
        $bodyTableClear = new \Google_Service_Sheets_ValueRange([
            'values' => [],
        ]);
        $clear = new Sheets\ClearValuesRequest();

        $range = 'список';
        $service->spreadsheets_values->clear(
            $table->spreadsheetId,
            $range,
            $clear
        );
        $service->spreadsheets_values->update(
            $table->spreadsheetId,
            $range,
            $bodyTableNew,
            ['valueInputOption' => 'RAW']
        );
    }

    private function createValuesForTable(): array
    {
        $data[] = $this->fields;
        foreach ($this->values as $key => $value) {
            $data_row =[];
            foreach ($this->fields as $field) {
                isset($value[$field]) ?  $data_row[] = $value[$field] : null;
            }
            $data[] = $data_row;
        }
        return $data;
    }
    public function copySheets(string $sourceSpreadsheetId): Spreadsheet
    {
        $this->ClientAuth();
        $sheetsService = new Sheets($this->client);

        // 1. Получаем исходный файл и его листы
        $spreadsheet = $sheetsService->spreadsheets->get($sourceSpreadsheetId);
        $sheets = $spreadsheet->getSheets();

        if (empty($sheets)) {
            throw new \Exception("В исходном файле нет листов.");
        }

        // 2. Создаем новый Google Sheet
        $newSpreadsheet = $this->createTable("Копия " . $spreadsheet->getProperties()->getTitle());
        $newSpreadsheetId = $newSpreadsheet->spreadsheetId;

        // 3. Копируем и переименовываем листы
        foreach ($sheets as $sheet) {
            $sheetId = $sheet->getProperties()->getSheetId();
            $originalSheetTitle = $sheet->getProperties()->getTitle();

            // Копируем лист
            $copyRequest = new \Google_Service_Sheets_CopySheetToAnotherSpreadsheetRequest([
                'destinationSpreadsheetId' => $newSpreadsheetId
            ]);
            $copiedSheet = $sheetsService->spreadsheets_sheets->copyTo($sourceSpreadsheetId, $sheetId, $copyRequest);
            $copiedSheetId = $copiedSheet->getSheetId();

            // Переименовываем лист в оригинальное название
            $this->renameSheet($newSpreadsheetId, $copiedSheetId, $originalSheetTitle);
        }

        // 4. Удаляем дефолтный лист "Sheet1", созданный по умолчанию
        $this->removeDefaultSheet($newSpreadsheetId);

        // 5. Даем доступ
        $this->addAccess($newSpreadsheet);

        // 6. Возвращаем объект с информацией о новом файле
        return $newSpreadsheet;
//        return (object)[
//            'url' => "https://docs.google.com/spreadsheets/d/$newSpreadsheetId",
//            'sheetID' => $newSpreadsheetId
//        ];
    }

    private function renameSheet(string $spreadsheetId, int $sheetId, string $newTitle): void
    {
        $sheetsService = new Sheets($this->client);

        $updateRequest = new \Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
            'requests' => [
                [
                    'updateSheetProperties' => [
                        'properties' => [
                            'sheetId' => $sheetId,
                            'title' => $newTitle
                        ],
                        'fields' => 'title'
                    ]
                ]
            ]
        ]);

        $sheetsService->spreadsheets->batchUpdate($spreadsheetId, $updateRequest);
    }

    private function removeDefaultSheet(string $spreadsheetId): void
    {
        $sheetsService = new Sheets($this->client);
        $spreadsheet = $sheetsService->spreadsheets->get($spreadsheetId);
        $sheets = $spreadsheet->getSheets();

        if (count($sheets) > 1) {
            foreach ($sheets as $sheet) {
                $sheetTitle = $sheet->getProperties()->getTitle();
                $sheetId = $sheet->getProperties()->getSheetId();

                if ($sheetTitle === 'Sheet1') { // Ищем дефолтный лист
                    $deleteRequest = new \Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
                        'requests' => [
                            ['deleteSheet' => ['sheetId' => $sheetId]]
                        ]
                    ]);

                    $sheetsService->spreadsheets->batchUpdate($spreadsheetId, $deleteRequest);
                    break; // Удаляем только первый найденный "Sheet1"
                }
            }
        }
    }
}
