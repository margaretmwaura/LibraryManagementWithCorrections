<?php


namespace App\Repository\Interfaces;



use Illuminate\Http\Request;

interface BookRepositoryInterface
{
    public function all();
    public function storeRecord($request,$id);
    public function deleteRecord($id);
    public function updateRecord(Request $request);


}
