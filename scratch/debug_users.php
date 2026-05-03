<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use App\Models\User;

$users = User::all();
foreach ($users as $user) {
    echo "ID: " . $user->id . " - Created At: " . ($user->created_at ? $user->created_at->toDateTimeString() : 'NULL') . " (" . gettype($user->created_at) . ")\n";
    if (is_object($user->created_at)) {
        echo "Class: " . get_class($user->created_at) . "\n";
    }
}
