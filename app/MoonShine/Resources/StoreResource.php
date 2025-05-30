<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Store;
use App\MoonShine\Pages\Store\StoreIndexPage;
use App\MoonShine\Pages\Store\StoreFormPage;
use App\MoonShine\Pages\Store\StoreDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Store, StoreIndexPage, StoreFormPage, StoreDetailPage>
 */
class StoreResource extends ModelResource
{
    protected string $model = Store::class;

    protected string $title = 'Магазины';
    protected ?\MoonShine\Support\Enums\ClickAction $clickAction = ClickAction::DETAIL;
    protected bool $simplePaginate = true;
    protected string $column = 'login';

    /**
     * @return list<Page>
     */
    protected function pages(): array
    {
        return [
            StoreIndexPage::class,
            StoreFormPage::class,
            StoreDetailPage::class,
        ];
    }

    protected function search(): array
    {
        return [
            'id',
            'login',
            'password_1',
            'password_2',
        ];
    }
    protected function beforeCreating(mixed $item): mixed
    {
        if(request()->has('user_id')) {
            $item->user_id = request('user_id');
        }
        return $item;
    }

    /**
     * @param Store $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
    protected function filters(): iterable
    {
        return [
            Number::make('ID', 'id'),
            Text::make('Логин', 'login'),
        ];
    }
}
