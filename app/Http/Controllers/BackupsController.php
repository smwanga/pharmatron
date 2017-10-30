<?php

namespace App\Http\Controllers;

use Spatie\Backup\BackupDestination\BackupCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Filesystem\Factory as Filesystem;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Support\Config;
use App\Entities\AppConfig;

class BackupsController extends Controller
{
    /**
     * The filesystem dist instance.
     *
     * @var Filesystem
     **/
    protected $disk;
    /**
     * AppConfig eloquent model.
     *
     * @var AppConfig
     **/
    protected $config;

    /**
     * Repository.
     *
     * @var Config
     **/
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @param AppConfig $config
     **/
    public function __construct(Filesystem $disk, AppConfig $config)
    {
        $this->config = $config;
        $this->repository = new Config($config->all());
        $this->disk = $disk->disk('local');
    }

    /**
     * List all the available backups.
     *
     * @return \Illuminate\Http\Response
     **/
    public function index()
    {
        $config = $this->repository;
        $collection = new BackupCollection();
        $name = config('laravel-backup.backup.name');
        $items = $collection->createFromFiles($this->disk, $this->disk->files($name));
        $backups = $this->paginate($items);

        return view('settings.backups', compact('backups', 'config'));
    }

    /**
     * Run a backup task.
     *
     * @return \Illuminate\Http\RedirectResponse
     **/
    public function create()
    {
        \Artisan::call('backup:run');

        return with_info('Backup was successful');
    }

    /**
     * Download a backup zip file from server.
     *
     * @return \Illuminate\Http\Response
     **/
    public function download(Request $request)
    {
        $path = $request->get('file');
        if ($this->disk->exists($path)) {
            return response()->download(storage_path('app/'.$path));
        }

        return with_info('Sorry the requested file does not exist on this server', 'error', 'File Not Found');
    }

    /**
     * Delete a backup from the filesystem.
     *
     * @return \Illuminate\Http\Response
     **/
    public function delete(Request $request)
    {
        $path = $request->get('file');
        if ($this->disk->exists($path)) {
            $this->disk->delete($path);

            return with_info('The backup file was deleted');
        }
    }

    /**
     * Paginate backup results.
     *
     * @param array|Collection $items
     * @param int              $perPage
     * @param int              $page
     * @param array            $options
     *
     * @return LengthAwarePaginator
     */
    protected function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
