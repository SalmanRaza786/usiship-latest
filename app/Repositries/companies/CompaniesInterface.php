<?php


namespace App\Repositries\companies;
interface CompaniesInterface
{


    public function companiesList($request);
    public function editCompanies($id);
    public function deleteCompanies($id);
    public function companiesSave($request,$id);
    public function getAllCompanies();



}
