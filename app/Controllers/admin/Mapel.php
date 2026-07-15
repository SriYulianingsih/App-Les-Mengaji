<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MapelModel;

class Mapel extends BaseController
{
    protected $mapelModel;

    public function __construct()
    {
        $this->mapelModel = new MapelModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Mata Pelajaran',
            'mapel' => $this->mapelModel->findAll()
        ];
        return view('admin/mapel/index', $data);
    }

    public function create()
    {
        return view('admin/mapel/create', ['title' => 'Tambah Mapel']);
    }

    public function store()
    {
        if (!$this->validate([
            'nama_mapel' => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->mapelModel->save([
            'nama_mapel' => $this->request->getPost('nama_mapel'),
            'keterangan' => $this->request->getPost('keterangan'),
        ]);

        return redirect()->to('/admin/mapel')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mapel = $this->mapelModel->find($id);
        if (!$mapel) return redirect()->to('/admin/mapel');

        $data = [
            'title' => 'Edit Mapel',
            'mapel' => $mapel
        ];
        return view('admin/mapel/edit', $data);
    }

    public function update($id)
    {
        $this->mapelModel->update($id, [
            'nama_mapel' => $this->request->getPost('nama_mapel'),
            'keterangan' => $this->request->getPost('keterangan'),
        ]);

        return redirect()->to('/admin/mapel')->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->mapelModel->delete($id);
        return redirect()->to('/admin/mapel')->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}