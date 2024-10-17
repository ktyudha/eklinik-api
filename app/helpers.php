<?php

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

if (!function_exists('customPaginate')) {
    /**
     * Custom pagination for index endpoints with a default limit of 10.
     *
     * @param Model $model
     * @param array $collectionInfo An array containing the property name, resource class, and time order.
     * @param int $limit
     * @param array $filters
     * @return array An array containing the paginated data and pagination details.
     */
    function customPaginate(Model|Builder $model, array $collectionInfo, int $limit, array $filters = []): array
    {
        $sortByProperty = $collectionInfo['sort_by_property'] ?? 'created_at';

        if (array_key_exists('sort_by', $collectionInfo)) {
            $sortedItems = $model->{$collectionInfo['sort_by']}($sortByProperty);
        } else {
            if (str_contains($sortByProperty, '.')) {
                [$relation, $column] = explode('.', $sortByProperty);

                $relatedTable = $model->getModel()->{$relation}()->getRelated()->getTable();
                $relatedKey = $model->getModel()->{$relation}()->getRelated()->getKeyName();
                $foreignKey = $model->getModel()->{$relation}()->getForeignKeyName();

                $sortedItems = $model
                    ->leftJoin($relatedTable, "{$relatedTable}.{$relatedKey}", '=', "{$model->getModel()->getTable()}.{$foreignKey}")
                    ->orderBy("{$relatedTable}.{$column}", $collectionInfo['order_direction'] ?? 'asc')
                    ->select("{$model->getModel()->getTable()}.*");
            } else {
                $sortedItems = $model->orderBy($sortByProperty, $collectionInfo['order_direction'] ?? 'asc');
            }
        }

        if (array_key_exists('relations', $collectionInfo)) {
            $sortedItems->with($collectionInfo['relations']);
        }

        if ($filters) {
            $sortedItems->filters($filters);
        }

        $paginatedItems = $sortedItems->paginate($limit);
        $items = $paginatedItems->items();

        $paginationData = array_diff_key($paginatedItems->toArray(), ['data' => null]);

        $resource = $collectionInfo['resource'];
        $propertyName = $collectionInfo['property_name'];

        return [
            $propertyName => $resource::collection($items),
            'pagination' => $paginationData,
        ];
    }
}


if (!function_exists('paginateCollection')) {
    /**
     * Paginate a collection of items.
     *
     * @param \Illuminate\Support\Collection $results
     * @param mixed $page
     * @param mixed $perPage
     * @param mixed $path
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    function paginateCollection(Collection $collection, mixed $page = null, mixed $limit = null, mixed $path = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $perPage = $limit ?? 10;

        $items = array_values($collection->flatten()->forPage($page, $perPage)->toArray());

        $paginator = new LengthAwarePaginator(
            $items,
            $collection->count(),
            $perPage,
            $page
        );

        if ($path != null) {
            $paginator->setPath($path);
        }

        return $paginator;
    }
}

if (!function_exists('paginateArray')) {
    /**
     * Paginate a collection of items.
     *
     * @param \Illuminate\Support\Collection $results
     * @param mixed $page
     * @param mixed $perPage
     * @param mixed $path
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    function paginateArray(array $array, mixed $page = null, mixed $limit = null, mixed $path = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $perPage = $limit ?? 10;

        $collection = collect($array);

        $items = array_values($collection->forPage($page, $perPage)->toArray());

        $paginator = new LengthAwarePaginator(
            $items,
            $collection->count(),
            $perPage,
            $page
        );

        if ($path != null) {
            $paginator->setPath($path);
        }

        return $paginator;
    }
}

if (!function_exists('trimStringAfterLastBackSlash')) {
    /**
     * Custom string to trim after last back slash.
     *
     * @param string $inputString
     */
    function trimStringAfterLastBackSlash(string $inputString)
    {
        $segments = explode('\\', $inputString);
        $trimmedString = end($segments);

        return $trimmedString;
    }
}

if (!function_exists('excelDateToRealDate')) {
    /**
     * Convert date from excel epoch date to human readable date in Y-m-d format.
     *
     * @param string $inputString
     */
    function excelDateToRealDate(int $excelDateEpoch)
    {
        $excelEpoch = Carbon\Carbon::create(1900, 1, 1);
        $realDate = $excelEpoch->addDays($excelDateEpoch - 2)->format('Y-m-d');

        return $realDate;
    }
}

if (!function_exists('generateRandomFileName')) {
    /**
     * Generate random file name while still getting the original extension type.
     *
     * @param string $inputString
     */
    function generateRandomFileName($file)
    {
        $randomFileName = Str::random() . '.' . $file->getClientOriginalExtension();

        return $randomFileName;
    }
}

if (!function_exists('csvToArray')) {
    /**
     * Return array from file csv, skipping the first row
     */
    function csvToArray(array $headers, string $filename, string $delimiter = ';', int $chunkSize = 1000): array
    {
        $data = [];

        if (!file_exists($filename) || !is_readable($filename)) {
            return $data;
        }

        $handle = fopen($filename, 'r');
        if ($handle !== false) {

            // Skip the first row of the csv file
            fgetcsv($handle, 1000, $delimiter);

            // While file has not yet reached the end of file, run the logic inside the loop
            while (!feof($handle)) {
                $chunk = [];
                for ($i = 0; $i < $chunkSize && ($row = fgetcsv($handle, 1000, $delimiter)) !== false; $i++) {
                    $chunk[] = array_combine($headers, $row);
                }

                $data = array_merge($data, $chunk);
            }
            fclose($handle);
        }

        return $data;
    }
}

if (!function_exists('calculatePercentage')) {
    /**
     * Return a percentage string from a number with 2 decimal places.
     */
    function calculatePercentage(int $dividend, int $divisor): string
    {
        try {
            $percentage = ($dividend / $divisor) * 100;
            if ($percentage == 100 || $percentage == 0) {
                return $percentage == 100 ? "100%" : "0%";
            } else {
                $roundedPercentage = abs($percentage) < 0.01 ? 0.01 : $percentage;
                return number_format($roundedPercentage, 2) . "%";
            }
        } catch (DivisionByZeroError $e) {
            return "0%";
        }
    }
}

if (!function_exists('generateRandomString')) {
    /**
     * Generate random string with a default length of 6.
     */
    function generateRandomString(?string $excludeChars, ?int $length = 6)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHJKMNPQRSTUVWXY1Z23456789';

        if ($excludeChars) {
            $characters = str_replace(str_split($excludeChars), '', $characters);
        }

        $randomString = '';
        $charactersLength = strlen($characters);

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}

if (!function_exists('generateMedicalRecordNumber')) {
    function generateMedicalRecordNumber($lastRecordNo)
    {
        // Dapatkan tahun dan bulan dari nomor rekam medis terakhir
        $lastYearMonth = substr($lastRecordNo, 0, 4); // Mengambil 4 karakter pertama (YYMM)

        // Dapatkan tahun dan bulan saat ini
        $currentYearMonth = Carbon::now()->format('ym');

        if ($lastRecordNo == 0 || $lastYearMonth != $currentYearMonth) {
            // Jika tidak ada rekam medis sebelumnya atau bulan berbeda, reset ke 1
            $newSequence = str_pad(1, 6, '0', STR_PAD_LEFT);
        } else {
            // Ambil bagian angka urut terakhir dari nomor rekam medis sebelumnya
            $lastSequence = (int)substr($lastRecordNo, -6);

            // Tambahkan 1 untuk membuat nomor urut baru
            $newSequence = str_pad($lastSequence + 1, 6, '0', STR_PAD_LEFT);
        }

        // Gabungkan tahun bulan dengan nomor urut baru
        $newMedicalRecordNo = $currentYearMonth . $newSequence;

        return $newMedicalRecordNo;
    }
}
