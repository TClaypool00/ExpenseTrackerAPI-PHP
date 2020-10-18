<?php
interface IUserRepository {
    public function getAll($search = null);

    public function getUserByEmail($eamil);

    public function getUserById($id);

    public function userExist($id);

    public function addUser(CoreUser $user);

    public function updateUser(CoreUser $user);

    public function removeUser($id);
}