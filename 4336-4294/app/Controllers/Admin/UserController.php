<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function index()
    {
        return view('admin/users/index', ['users' => $this->model->findAll()]);
    }

    public function create()
    {
        $nom = trim($this->request->getPost('nom'));
        $login = trim($this->request->getPost('login'));
        $password = (string) $this->request->getPost('password');

        if (empty($nom) || empty($login) || strlen($password) < 6) {
            return redirect()->to('/admin/utilisateurs')
                ->with('error', 'Nom, login requis et mot de passe d\'au moins 6 caractères.');
        }

        if ($this->model->findByLogin($login)) {
            return redirect()->to('/admin/utilisateurs')->with('error', 'Ce login existe déjà.');
        }

        $this->model->creerAdmin($nom, $login, $password);

        return redirect()->to('/admin/utilisateurs')->with('success', 'Administrateur créé.');
    }

    public function toggle($id)
    {
        $user = $this->model->find($id);

        if ($user && (int) $id !== (int) session()->get('admin_id')) {
            $this->model->update($id, ['actif' => $user['actif'] ? 0 : 1]);
        } else {
            return redirect()->to('/admin/utilisateurs')->with('error', 'Vous ne pouvez pas désactiver votre propre compte.');
        }

        return redirect()->to('/admin/utilisateurs')->with('success', 'Statut mis à jour.');
    }

    public function delete($id)
    {
        if ((int) $id === (int) session()->get('admin_id')) {
            return redirect()->to('/admin/utilisateurs')->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $this->model->delete($id);
        return redirect()->to('/admin/utilisateurs')->with('success', 'Administrateur supprimé.');
    }
}
