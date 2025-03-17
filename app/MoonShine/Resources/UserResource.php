<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Fields\Relationships\HasOne;
use MoonShine\Laravel\Fields\Relationships\MorphToMany;
use MoonShine\Laravel\Models\MoonshineUser;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Laravel\Models\MoonshineUserRole;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Support\Enums\Color;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Badge;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Flex;
use MoonShine\UI\Components\Link;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Checkbox;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Password;
use MoonShine\UI\Fields\PasswordRepeat;
use MoonShine\UI\Fields\Phone;
use MoonShine\UI\Fields\Text;
use Spatie\Permission\Models\Role;
use App\MoonShine\Resources\PhoneResource;

#[Icon('users')]
/**
 * @extends ModelResource<MoonshineUser>
 */
class UserResource extends ModelResource
{
    protected string $model = User::class;

    protected string $column = 'name';

//    protected array $with = ['roles'];

    protected bool $simplePaginate = true;

    protected bool $columnSelection = true;
    protected ?\MoonShine\Support\Enums\ClickAction $clickAction = ClickAction::DETAIL;

    public function getTitle(): string
    {
        return __('Пользователи');
    }

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),

            MorphToMany::make(
                __('moonshine::ui.resource.role'),
                'roles',
                formatted: static fn (Role $model) => $model->name,
                resource: RoleResource::class,
            )->badge(Color::PURPLE)->inLine(
                separator: ' ',
                badge: fn($model, $value) => Badge::make((string) $value, 'primary'),
                link: fn(Role $property, $value, $field) => (string) Link::make(
                    app(RoleResource::class)->getDetailPageUrl($property->id),
                    $value
                )
            ),
            Text::make(__('moonshine::ui.resource.name'), 'name'),

            Image::make(__('moonshine::ui.resource.avatar'), 'avatar')->modifyRawValue(fn (
                ?string $raw
            ): string => $raw ?? ''),

            Date::make(__('moonshine::ui.resource.created_at'), 'created_at')
                ->format("d.m.Y")
                ->sortable(),

            Email::make(__('moonshine::ui.resource.email'), 'email')
                ->sortable(),
            Checkbox::make('Подверждена ли почта', 'email_verified_at')
        ];
    }

    protected function detailFields(): iterable
    {
        return $this->indexFields();
    }

    protected function formFields(): iterable
    {
//        $item = $this->getResource()->getItem();
        return [
            Box::make([
                Tabs::make([
                    Tab::make(__('moonshine::ui.resource.main_information'), [
                        ID::make()->sortable(),

                        MorphToMany::make(
                            __('moonshine::ui.resource.role'),
                            'roles',
                            formatted: static fn (Role $model) => $model->name,
                            resource: RoleResource::class,
                        )
                            ->selectMode()
                            ->valuesQuery(static fn (Builder $q) => $q->select(['id', 'name'])),

                        Flex::make([
                            Text::make(__('moonshine::ui.resource.name'), 'name')
                                ->required(),
                            Email::make(__('moonshine::ui.resource.email'), 'email')
                                ->required(),
                            Date::make('Подтверждение почты', 'email_verified_at')->withTime(),
                            Phone::make('Телефон(Не изменяемое поле)', 'phone.number'),
                            Date::make('Подтверждение телефона(Не изменяемое поле)', 'phone.number_verified_at')->withTime(),

                        ]),

                        Image::make(__('moonshine::ui.resource.avatar'), 'avatar')
                            ->disk(moonshineConfig()->getDisk())
                            ->dir('users')
                            ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif']),

                    ])->icon('user-circle'),

                    Tab::make(__('moonshine::ui.resource.password'), [
                        Collapse::make(__('moonshine::ui.resource.change_password'), [
                            Password::make(__('moonshine::ui.resource.password'), 'password')
                                ->customAttributes(['autocomplete' => 'new-password'])
                                ->eye(),

                            PasswordRepeat::make(__('moonshine::ui.resource.repeat_password'), 'password_repeat')
                                ->customAttributes(['autocomplete' => 'confirm-password'])
                                ->eye(),
                            HasMany::make('Документы', 'documents', resource: DocumentResource::class)->searchable(false)
                        ])->icon('lock-closed'),
                    ])->icon('lock-closed'),
                ]),
            ]),
        ];
    }

    /**
     * @return array{name: array|string, moonshine_user_role_id: array|string, email: array|string, password: array|string}
     */
    protected function rules($item): array
    {
        return [
            'name' => 'required',
//            'moonshine_user_role_id' => 'required',
            'surname' => 'required',
            'email' => [
                'sometimes',
                'bail',
                'required',
                'email',
            ],
            'password' => $item->exists
                ? 'sometimes|nullable|min:6|required_with:password_repeat|same:password_repeat'
                : 'required|min:6|required_with:password_repeat|same:password_repeat',
        ];
    }

    protected function search(): array
    {
        return [
            'id',
            'email',
        ];
    }

    protected function filters(): iterable
    {
        return [
//            BelongsTo::make(
//                __('moonshine::ui.resource.role'),
//                'moonshineUserRole',
//                formatted: static fn (MoonshineUserRole $model) => $model->name,
//                resource: MoonShineUserRoleResource::class,
//            )->valuesQuery(static fn (Builder $q) => $q->select(['id', 'name'])),

            Email::make('E-mail', 'email'),
        ];
    }
}
