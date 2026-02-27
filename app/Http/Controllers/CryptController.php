<?php

namespace App\Http\Controllers;

use Crypt;
use Illuminate\Http\Request;

class CryptController extends Controller
{
    public function index()
    {
        $encrypted = Crypt::encryptString('Belajar Laravel Di malasngoding.com');
        $decrypted = Crypt::decryptString($encrypted);
        $decrypted = Crypt::decryptString("eyJpdiI6IkNxd1B0TFRkaTdncEZDTHZQL2hLYmc9PSIsInZhbHVlIjoiWFhxSmJpVWN5ZXF1TGJ2SmRyY3ZkLzdZSW1yN2tkKy91aVdROG9XN3M4eDFRNGNtMUlrQjZ2eTNUM0QzenhMayIsIm1hYyI6IjgxYjRhNTAxN2U4ZWVhYWI1ZGRiMmI5YTRiNGZlYzNkMDJlMWE3YzUxN2YwNTc1NzdmYzQ2MThjODhjNWU2NWEiLCJ0YWciOiIifQ==
");

        echo "Hasil Enkripsi : " . $encrypted;
        echo "<br/>";
        echo "<br/>";
        echo "Hasil Dekripsi : " . $decrypted;
        echo "<br/>";
        echo "Hasil Dekripsi Teks: " . $decrypted;
    }
}