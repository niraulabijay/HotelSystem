<h1>Hotel Systems</h1>

<h3>Important actions</h3>
<ul>
    <li>In config>cartalyst_sentinel.php change model from "USers" to "SystemUser"</li>
    <li>In SystemUsers.php ->click EloquentUser -> change table from "users" to "system_users"</li>
    <li>In config>filesystems.php add new section under disks as :</li>
    <p>
        'media_path' => [
            'driver' => 'local',
            'root' => storage_path('/media'),
            'url' => env('APP_URL').'/storage/media',
            'visibility' => 'public',
        ],
    </p>
    <li>In config>medialibrary.php change following:</li>
    <p>'disk_name' => env('MEDIA_DISK', 'media_path'),</p>
</ul>
