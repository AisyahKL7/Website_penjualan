<?php

namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\AntrianModel;
use App\Models\TransaksiModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    public function index()
    {
        if (session()->get('nama')) {
            return redirect()->to(base_url() . "/testController");
        }
        $user = $this->userModel->where('hapus', NULL)->findAll();
        unset($user["password"]);
        $data = [
            "user" => $user,
        ];
        return view('dashboard', $data);
    }
    public function auth()
    {
        $usersModel = new UserModel();
        $id = $this->request->getPost('idUser');
        $password = $this->request->getPost('pass');
        $user = $usersModel->where('id', $id)->first();

        if (empty($user)) {
            echo json_encode('<span class="badge badge-danger">Username Salah :(</span>');
        } else if (password_verify($password, $user['password'])) {
            session()->set('nama', $user["nama"]);
            session()->set('rule', $user["rule"]);
            session()->set('id', $user["id"]);
            echo json_encode("");
        } else {
            echo json_encode('<span class="badge badge-danger">Password Salah :(</span>');
        }
    }

    public function logout()
    {
        session()->remove('nama');
        session()->remove('rule');
        return redirect()->to(base_url() . "/dashboard");
    }
}
