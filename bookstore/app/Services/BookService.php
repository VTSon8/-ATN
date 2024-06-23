<?php
namespace App\Services;

class BookService {

    /**
     * @param  string  $name
     * @return array
     */
    public function sortByColumn(string $name): array
    {
        $arr_condition = explode('-', $name);

        return [
            'column' =>   $arr_condition[0] ?? 'name',
            'dir' =>   $arr_condition[1] ?? 'desc',
        ];
    }

}
