<?php

namespace corg\Model;

class Files extends \corg\Model
{
    public function getAllFilesTiny()
    {
        return \corg\Db::getInstance()
            ->query('CALL get_all_files_tiny()')
            ->fetchALL(\PDO::FETCH_COLUMN);
    }

    public function getAllFilesShort()
    {
        return \corg\Db::getInstance()
            ->query('CALL get_all_files_short()')
            ->fetchALL(\PDO::FETCH_UNIQUE);
    }

    public function getFiles($id)
    {
        $pod = \corg\Db::getInstance()
            ->prepare('CALL get_files(:id)');
        $pod->execute(['id' => $this->nullifyStr($id)]);

        return $pod->fetchALL(\PDO::FETCH_UNIQUE);
    }

    public function getFile($id)
    {
        $pod = \corg\Db::getInstance()
            ->prepare('CALL get_file(:id)');
        $pod->execute(['id' => $this->nullifyStr($id)]);

        return $pod->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function setFile($size, $mtype, $name, $description)
    {
        \corg\Db::getInstance()
            ->prepare('CALL set_file(:size, :mtype, :name, :description)')
            ->execute(
                [
                    'size' => $this->nullifyStr($size),
                    'mtype' => $this->nullifyStr($mtype),
                    'name' => $this->nullifyStr($name),
                    'description' => $this->nullifyStr($description)
                ]
            );
    }

    public function setReference($activity_id, $file_id)
    {
        \corg\Db::getInstance()
            ->prepare('CALL set_reference(:activity_id, :file_id)')
            ->execute(
                [
                    'activity_id' => $this->nullifyStr($activity_id),
                    'file_id' => $this->nullifyStr($file_id)
                ]
            );
    }

    public function getReferences($id)
    {
        $pod = \corg\Db::getInstance()
            ->prepare('CALL get_references(:id)');
        $pod->execute(['id' => $this->nullifyStr($id)]);

        return $pod->fetchALL(\PDO::FETCH_COLUMN);
    }

    public function getAbleToReference($id)
    {
        $pod = \corg\Db::getInstance()
            ->prepare('CALL get_able_to_reference(:id)');
        $pod->execute(['id' => $this->nullifyStr($id)]);

        return $pod->fetchALL(\PDO::FETCH_COLUMN);
    }

    public function getLastFileId()
    {
        return \corg\Db::getInstance()
            ->query('CALL get_last_file_id()')
            ->fetchColumn();
    }

    public function getFileName($id)
    {
        $pod = \corg\Db::getInstance()
            ->prepare('CALL get_file_name(:id)');
        $pod->execute(['id' => $this->nullifyStr($id)]);

        return $pod->fetchColumn();
    }

    public function unsetFile($id)
    {
        \corg\Db::getInstance()
            ->prepare('CALL unset_file(:id)')
            ->execute(['id' => $id]);
    }

    public function unsetReference($activity_id, $file_id)
    {
        \corg\Db::getInstance()
            ->prepare('CALL unset_reference(:activity_id, :file_id)')
            ->execute(
                [
                    'activity_id' => $activity_id,
                    'file_id' => $file_id
                ]
            );
    }

    public function unsetOrphans()
    {
        \corg\Db::getInstance()
            ->exec('CALL unset_orphans()');
    }
}
