<?php

namespace Rovahub\Cloudflare\Repositories\Interfaces;

interface RepositoryInterface
{
    public function resetModel();

    public function create(array $data);

    public function setModel();

    public function count($condition = []);

    public function pagination($page = 20, $condition = []);

    public function findById($id);

    public function getByFirst(array $condition = [], array $select = ['*']);

    public function updateById($id, array $data);

    public function deleteById($id);

    public function delete($ids = []);

}
