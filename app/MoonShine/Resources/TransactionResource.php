<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;
use App\MoonShine\Pages\Transaction\TransactionIndexPage;
use App\MoonShine\Pages\Transaction\TransactionFormPage;
use App\MoonShine\Pages\Transaction\TransactionDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\UI\Components\Boolean;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Transaction, TransactionIndexPage, TransactionFormPage, TransactionDetailPage>
 */
class TransactionResource extends ModelResource
{
    protected string $model = Transaction::class;

    protected string $title = 'Транзакции';
    protected bool $simplePaginate = true;
    protected ?\MoonShine\Support\Enums\ClickAction $clickAction = ClickAction::DETAIL;
    /**
     * @return list<Page>
     */
    protected function pages(): array
    {
        return [
            TransactionIndexPage::class,
            TransactionFormPage::class,
            TransactionDetailPage::class,
        ];
    }

    protected function search(): array
    {
        return [
            'id',
            'desc,'
        ];
    }

    /**
     * @param Transaction $item
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
        ];
    }
}
