<?php

namespace Tests;

use Closure;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\SQLiteBuilder;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Fluent;

abstract class TestCase extends BaseTestCase
{
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        $this->hotfixSqlite();
        parent::__construct($name, $data, $dataName);
    }
    public function hotfixSqlite()
    {
        \Illuminate\Database\Connection::resolverFor('sqlite',
            function ($connection, $database, $prefix, $config) {
                return new class($connection, $database, $prefix, $config)
                    extends SQLiteConnection {
                    public function getSchemaBuilder()
                    {
                        if ($this->schemaGrammar === null) {
                            $this->useDefaultSchemaGrammar();
                        }

                        return new class($this) extends SQLiteBuilder {
                            protected function createBlueprint($table, Closure $callback = null)
                            {
                                return new class($table, $callback) extends Blueprint {
                                    public function dropForeign($index)
                                    {
                                        return new Fluent();
                                    }
                                };
                            }
                        };
                    }
                };
            });
    }
    public function resolveSqlite()
    {
        Connection::resolverFor('sqlite',
            function ($connection, $database, $prefix, $config) {
                return new class($connection, $database, $prefix, $config)
                    extends SQLiteConnection {
                    public function getSchemaBuilder()
                    {
                        if ($this->schemaGrammar === null) {
                            $this->useDefaultSchemaGrammar();
                        }

                        return new class($this) extends SQLiteBuilder {
                            protected function createBlueprint($table, Closure $callback = null)
                            {
                                return new class($table, $callback) extends Blueprint {
                                    public function dropForeign($index)
                                    {
                                        return new Fluent();
                                    }
                                };
                            }
                        };
                    }
                };
            });
    }
}
