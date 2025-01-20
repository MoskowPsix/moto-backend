<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\MoonShine\Pages\Service\ServiceDetailPage;
use App\MoonShine\Pages\Service\ServiceFormPage;
use App\MoonShine\Pages\Service\ServiceIndexPage;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;

use MoonShine\Laravel\Pages\Page;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;

/**
 * @extends ModelResource<Service>
 */
class ServiceResource extends ModelResource
{
    protected string $model = Service::class;

    protected string $title = 'Сервисы';
    protected string $column = 'name';

    /**
     * @return list<Page>
     */

    protected function pages(): array
    {
        return [
            ServiceIndexPage::class,
            ServiceDetailPage::class,
            ServiceFormPage::class
        ];
    }



    /**
     * @param Service $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
