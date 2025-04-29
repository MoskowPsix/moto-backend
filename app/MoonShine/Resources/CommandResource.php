<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Traits\MoonShine\Resources\CommandResourceTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Command;
use App\MoonShine\Pages\Command\CommandIndexPage;
use App\MoonShine\Pages\Command\CommandFormPage;
use App\MoonShine\Pages\Command\CommandDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Support\Enums\ClickAction;

/**
 * @extends ModelResource<Command, CommandIndexPage, CommandFormPage, CommandDetailPage>
 */
class CommandResource extends ModelResource
{
    protected string $model = Command::class;
    protected bool $simplePaginate = true;
    protected bool $columnSelection = true;
    protected string $column = 'name';
    protected ?\MoonShine\Support\Enums\ClickAction $clickAction = ClickAction::DETAIL;
    protected string $title = 'Команды';

    /**
     * @return list<Page>
     */
    protected function pages(): array
    {
        return [
            CommandIndexPage::class,
            CommandFormPage::class,
            CommandDetailPage::class,
        ];
    }

    protected function search(): array
    {
        return [
            'id',
            'name',
            'city',
            'user.name',
            'location.name'
        ];
    }

    /**
     * @param Command $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
