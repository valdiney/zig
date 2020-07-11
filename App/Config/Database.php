<?php

return [

  // conexão feita com mysql por default
  'connection'  => getenv('DB_CONNECTION') ?? 'mysql',

  'connections' => [

    'mysql' => [
      'host' => getenv('HOST_NAME')     ?? 'localhost',
      'user' => getenv('HOST_USERNAME') ?? 'root',
      'pass' => getenv('HOST_PASSWORD') ?? '',
      'db'   => getenv('HOST_DBNAME')   ?? 'zig',
      // default PDO::FETCH_OBJ
      // 'fetch' => \PDO::FETCH_ASSOC,
      // 'fetch_class' => Test::class
    ],

  ],

];
