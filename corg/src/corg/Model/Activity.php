<?php

namespace corg\Model;

class Activity extends \corg\Model
{
    public function getAllActivitiesTiny()
    {
        return \corg\Db::getInstance()
            ->query('CALL get_all_activities_tiny()')
            ->fetchALL(\PDO::FETCH_COLUMN);
    }

    public function getAllActivitiesShort()
    {
        return \corg\Db::getInstance()
            ->query('CALL get_all_activities_short()')
            ->fetchALL(\PDO::FETCH_UNIQUE);
    }

    public function getActivities($id)
    {
        $pod = \corg\Db::getInstance()
            ->prepare('CALL get_activities(:id)');
        $pod->execute(['id' => $this->nullifyStr($id)]);

        return $pod->fetchALL(\PDO::FETCH_UNIQUE);
    }

    public function getActivity($id)
    {
        $pod = \corg\Db::getInstance()
            ->prepare('CALL get_activity(:id)');
        $pod->execute(['id' => $this->nullifyStr($id)]);

        return $pod->fetch(\PDO::FETCH_ASSOC);
    }

    public function setActivity($name, $description, $customer_id, $employee_id)
    {
        \corg\Db::getInstance()
            ->prepare('CALL set_activity(:name, :description, :customer_id, :employee_id)')
            ->execute(
                [
                    'name' => $this->nullifyStr($name),
                    'description' => $this->nullifyStr($description),
                    'customer_id' => $this->nullifyStr($customer_id),
                    'employee_id' => $this->nullifyStr($employee_id)
                ]
            );
    }

    public function getLastActivityId()
    {
        return \corg\Db::getInstance()
            ->query('CALL get_last_activity_id()')
            ->fetchColumn();
    }

    public function unsetActivity($id)
    {
        \corg\Db::getInstance()
            ->prepare('CALL unset_activity(:id)')
            ->execute(['id' => $id]);
    }
}
