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

    public string $url;

    public array $fields;

    public array $values;
    private Client $client;

    public function create(string $table_name, array $fields = [], array $value = []): string
    {
        $this->ClientAuth();
        $this->fields = $fields;
        $this->values = $value;

        $table = $this->createTable($table_name);

        $this->addRows($table);
        $this->addAccess($table);

        $spriteSheetID = $table->spreadsheetId;

        $url = "https://docs.google.com/spreadsheets/d/$spriteSheetID";
        return $url;
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
            ]
            ]));
        return $service->spreadsheets->create($spreadSheet);
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

        $range = 'Sheet1!A1:Z10';

        $service->spreadsheets_values->append(
            $table->spreadsheetId,
            $range,
            $bodyTable,
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
}
