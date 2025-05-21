<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'make:action')]
class CreateAction extends GeneratorCommand
{
    protected $name = 'make:action';

    protected $description = 'Command for create action and contract action in your project';

    protected $type = 'Console command';

    public function handle()
    {
        parent::handle();
        if ($this->option('contract')) {
            $this->createContract();
            $this->registerBinding();
        }
    }

    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);
        $actionName = $this->argument('name');
        $rootNamespace = $this->laravel->getNamespace();


        return str_replace(['{{ contract }}'], '\\'.$rootNamespace . 'Contracts\Actions\\' . str_replace('/', '\\', $actionName) . 'Contract', $stub);
    }

    protected function getStub()
    {
        $relativePath = '/stubs/action.stub';

        return file_exists($customPath = $this->laravel->basePath(trim($relativePath, '/')))
            ? $customPath
            : __DIR__.$relativePath;
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the command'],
        ];
    }
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Actions';
    }
    protected function getOptions()
    {
        return [
            ['command', null, InputOption::VALUE_OPTIONAL, 'The terminal action that will be used to invoke the class'],
            ['contract', 'c', InputOption::VALUE_NONE, 'Create contract for action'],
        ];
    }

    protected function createContract()
    {
        $contract = Str::studly($this->argument('name'));

        $this->call('make:contract', [
            'name' => "Actions/{$contract}Contract",
        ]);
    }

    protected function registerBinding()
    {
        $actionName = $this->argument('name');
        $rootNamespace = $this->laravel->getNamespace();

        // Формируем полные имена классов
        $actionClass = $rootNamespace . 'Actions\\' . str_replace('/', '\\', $actionName);
        $contractClass = $rootNamespace . 'Contracts\Actions\\' . str_replace('/', '\\', $actionName) . 'Contract';

        $providerName = 'ActionServiceProvider';
        $providerPath = app_path('Providers/' . $providerName . '.php');

        // Создаем провайдер, если его нет
        if (!File::exists($providerPath)) {
            Artisan::call('make:provider', ['name' => $providerName]);
            $this->info("Создан провайдер $providerName. Добавьте его в config/app.php.");
        }

        $bindingEntry = "\\{$contractClass}::class => \\{$actionClass}::class,";

        $content = File::get($providerPath);

        // Проверяем существующую привязку
        if (str_contains($content, $bindingEntry)) {
            $this->info("Привязка уже существует в $providerName");
            return;
        }

        // Паттерн для поиска массива $bindings
        $pattern = '/(public\s+array\s+\$bindings\s*=\s*\[)([^\]]*)(\];)/s';

        if (preg_match($pattern, $content, $matches)) {
            // Добавляем новую привязку в начало массива
            $newContent = str_replace(
                $matches[0],
                $matches[1] . "\n\t\t" . $bindingEntry . $matches[2] . $matches[3],
                $content
            );
        } else {
            // Если массив $bindings не найден, создаем его
            $classPattern = '/(class\s+ActionServiceProvider\s+extends\s+ServiceProvider\s*\{)/';
            $newContent = preg_replace(
                $classPattern,
                "$1\n\n\tpublic array \$bindings = [\n\t\t" . $bindingEntry . "\n\t];",
                $content
            );
        }

        // Обновляем содержимое файла
        File::put($providerPath, $newContent);
        $this->info("Привязка добавлена в $providerName");
    }
}
