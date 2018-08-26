<?php
namespace bestellando\Model;

class Order
{
    public function beginTransaction()
    {
        \bestellando\Db::getInstance()
            ->beginTransaction();
    }

    public function commit()
    {
        \bestellando\Db::getInstance()
            ->commit();
    }

    public function rollBack()
    {
        \bestellando\Db::getInstance()
            ->rollBack();
    }

    public function selectDishes($short = 0)
    {
        if ($short == 1) {
            return \bestellando\Db::getInstance()
                ->query('CALL get_all_dishes_short()')
                ->fetchALL(\PDO::FETCH_KEY_PAIR);
        } else {
            return \bestellando\Db::getInstance()
                ->query('CALL get_all_dishes()')
                ->fetchALL();
        }
    }

    public function selectTables()
    {
        return \bestellando\Db::getInstance()
            ->query('CALL get_all_tables()')
            ->fetchALL(\PDO::FETCH_KEY_PAIR);
    }

    public function insertOrder($ttable_id = 0, $dish_id = 0)
    {
        \bestellando\Db::getInstance()
            ->prepare('CALL set_order(:ttable_id, :dish_id)')
            ->execute(['ttable_id' => $ttable_id, 'dish_id' => $dish_id]);
    }

    public function selectUnservableOrders()
    {
        return \bestellando\Db::getInstance()
            ->query('CALL get_all_unservable_orders()')
            ->fetchALL();
    }

    public function selectUnservableTables()
    {
        return \bestellando\Db::getInstance()
            ->query('CALL get_all_unservable_tables()')
            ->fetchALL(\PDO::FETCH_KEY_PAIR);
    }

    public function setServableOrder($id = 0)
    {
        \bestellando\Db::getInstance()
            ->prepare('CALL update_unservable_order(:id)')
            ->execute(['id' => $id]);
    }

    public function selectReadyOrders()
    {
        return \bestellando\Db::getInstance()
            ->query('CALL get_all_ready_orders()')
            ->fetchALL();
    }

    public function selectReadyTables()
    {
        return \bestellando\Db::getInstance()
            ->query('CALL get_all_ready_tables()')
            ->fetchALL(\PDO::FETCH_KEY_PAIR);
    }

    public function setServedOrder($id = 0)
    {
        \bestellando\Db::getInstance()
            ->prepare('CALL update_unserved_order(:id)')
            ->execute(['id' => $id]);
    }

    public function selectUnpaidOrders()
    {
        return \bestellando\Db::getInstance()
            ->query('CALL get_all_unpaid_orders()')
            ->fetchALL();
    }

    public function selectUnpaidTables()
    {
        return \bestellando\Db::getInstance()
            ->query('CALL get_all_unpaid_tables()')
            ->fetchALL(\PDO::FETCH_KEY_PAIR);
    }

    public function deleteUnpaidOrder($id = 0)
    {
        \bestellando\Db::getInstance()
            ->prepare('CALL delete_unpaid_order(:id)')
            ->execute(['id' => $id]);
    }

    public function selectUnpaidOrdersWithPrice() {
        return \bestellando\Db::getInstance()
            ->query('CALL get_all_unpaid_orders_with_price()')
            ->fetchALL(\PDO::FETCH_UNIQUE);
    }

    public function setPaidOrder($id = 0)
    {
        \bestellando\Db::getInstance()
            ->prepare('CALL update_unpaid_order(:id)')
            ->execute(['id' => $id]);
    }
}
?>
