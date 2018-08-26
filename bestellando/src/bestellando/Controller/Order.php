<?php
namespace bestellando\Controller;

class Order
{
    private $db;
    private $template;
    private $config;

    public function __construct()
    {
        $this->config = \bestellando\Config::get('site');
        $this->db = new \bestellando\Model\Order();
        $this->template = new \bestellando\Template(
            $this->config['view_path'] . "/base.phtml"
        );

        set_exception_handler([$this, 'exception']);
    }

    public function exception($e)
    {
        error_log($e);
        readfile ('error.php');
        exit(1);
    }

    protected function render($template, $data = [])
    {
        $this->config = \bestellando\Config::get('site');
        $this->template
             ->render($this->config['view_path'] . "/" . $template, $data);
    }

    public function cancelAction()
    {
        $orders = $this->db->selectUnpaidOrders();
        $tables = $this->db->selectUnpaidTables();

        $all_checked = 'unchecked';
        $selected_table = -1;
        $error_msg = [];

        if (!empty($_POST)) {
            $selected_table = $_POST['selected_table'];

            switch ($_POST['action']) {
            case 'set_all_checked':
                $all_checked = 'checked';
                break;
            case 'set_all_unchecked':
                $all_checked = 'unchecked';
                break;
            case 'filter_ok':
                $selected_table = $_POST['table'];
                break;
            case 'mark_ok':
                if (empty($_POST['checked'])) {
                    $error_msg[] = 'Mark an order, please.';
                    goto render;
                }
                try {
                    $this->db->beginTransaction();
                    foreach ($_POST['checked'] as $c) {
                        $this->db->deleteUnpaidOrder((int) $c);
                    }
                    $this->db->commit();
                } catch (\Exception $e) {
                    $this->db->rollBack();
                    $this->exception($e);
                }
            default:
                header('Location: /index.php');
                exit;
            }
        }

        render:
        $this->render("../views/index/cancel.phtml",
            [
                'all_checked' => $all_checked,
                'selected_table' => $selected_table,
                'orders' => $orders,
                'tables' => $tables,
                'error_msg' => $error_msg
            ]
        );
    }

    private function sum($input, $col)
    {
        return sprintf('%.2f', array_sum(array_column($input, $col)));
    }

    public function payAction()
    {
        session_name('mark-as-paid');
        session_start();

        $orders = $this->db->selectUnpaidOrdersWithPrice();
        $tables = $this->db->selectUnpaidTables();

        if (empty($_SESSION['pay'])) {
            $_SESSION['pay'] = [];
        } else {
            $orders = array_diff_key($orders, $_SESSION['pay']);
        }

        if (empty($_SESSION['pay'])) {
            $_SESSION['sum'] = sprintf('%.2f', 0);
        }

        $all_checked = 'unchecked';
        $all_checked2 = 'unchecked';
        $error_msg = [];

        if (!empty($_POST)) {
            switch ($_POST['action']) {
            case 'set_all_checked':
                $all_checked = 'checked';
                break;
            case 'set_all_unchecked':
                $all_checked = 'unchecked';
                break;
            case 'set_all_checked2':
                $all_checked2 = 'checked';
                break;
            case 'set_all_unchecked2':
                $all_checked2 = 'unchecked';
                break;
            case 'filter_ok':
                $_SESSION['selected_table'] = $_POST['table'];
                break;
            case 'filter_ok2':
                $_SESSION['selected_table2'] = $_POST['table2'];
                break;
            case 'add':
                if (empty($_POST['checked'])) {
                    $error_msg[] = 'Mark an order, please.';
                    goto render;
                }
                $flip = array_flip($_POST['checked']);
                $_SESSION['pay'] += array_intersect_key($orders, $flip);
                $_SESSION['sum'] = $this->sum($_SESSION['pay'], 'price');
                $orders = array_diff_key($orders, $flip);
                break;
            case 'remove':
                if (empty($_POST['added'])) {
                    $error_msg[] = 'Mark an order, please.';
                    goto render;
                }
                $flip = array_flip($_POST['added']);
                $orders += array_intersect_key($_SESSION['pay'], $flip);
                ksort($orders);
                $_SESSION['pay'] = array_diff_key($_SESSION['pay'], $flip);
                $_SESSION['sum'] = $this->sum($_SESSION['pay'], 'price');
                break;
            case 'receipt':
                header('Location: /receipt');
                exit;
                break;
            case 'mark_ok':
                if (empty($_SESSION['pay'])) {
                    $error_msg[] = 'Add an order, please.';
                    goto render;
                }
                try {
                    $this->db->beginTransaction();
                    foreach ($_SESSION['pay'] as $k => $v) {
                        $this->db->setPaidOrder($k);
                    }
                    $this->db->commit();
                } catch (\Exception $e) {
                    $this->db->rollBack();
                    $this->exception($e);
                }
            default:
                if (isset($_COOKIE[session_name()])) {
                    setcookie(session_name(), '', time()-3600, '/' );
                    $_SESSION = [];
                    session_destroy();
                }
                header('Location: /index.php');
                exit;
            }
        }

        $_SESSION['selected_table'] = !empty($_SESSION['selected_table']) ? $_SESSION['selected_table'] : -1;
        $_SESSION['selected_table2'] = !empty($_SESSION['selected_table2']) ? $_SESSION['selected_table2'] : -1;

        render:
        $this->render("../views/index/pay.phtml",
            [
                'tables' => $tables,
                'orders' => $orders,
                'all_checked' => $all_checked,
                'all_checked2' => $all_checked2,
                'error_msg' => $error_msg
            ]
        );
    }

    public function cookAction()
    {
        $orders = $this->db->selectUnservableOrders();
        $tables = $this->db->selectUnservableTables();

        $all_checked = 'unchecked';
        $selected_table = -1;
        $error_msg = [];

        if (!empty($_POST)) {
            $selected_table = $_POST['selected_table'];

            switch ($_POST['action']) {
            case 'set_all_checked':
                $all_checked = 'checked';
                break;
            case 'set_all_unchecked':
                $all_checked = 'unchecked';
                break;
            case 'filter_ok':
                $selected_table = $_POST['table'];
                break;
            case 'mark_ok':
                if(empty($_POST['checked'])) {
                    $error_msg[] = 'Mark an order, please.';
                    goto render;
                }
                try {
                    $this->db->beginTransaction();
                    foreach ($_POST['checked'] as $c) {
                        $this->db->setServableOrder($c);
                    }
                    $this->db->commit();
                } catch (\Exception $e) {
                    $this->db->rollBack();
                    $this->exception($e);
                }
            default:
                header('Location: /index.php');
                exit;
            }
        }

        render:
        $this->render("../views/index/cook.phtml",
            [
                'all_checked' => $all_checked,
                'selected_table' => $selected_table,
                'orders' => $orders,
                'tables' => $tables,
                'error_msg' => $error_msg
            ]
        );
    }

    public function serveAction()
    {
        $orders = $this->db->selectReadyOrders();
        $tables = $this->db->selectReadyTables();

        $all_checked = 'unchecked';
        $selected_table = -1;
        $error_msg = [];

        if (!empty($_POST)) {
            $selected_table = $_POST['selected_table'];

            switch ($_POST['action']) {
            case 'set_all_checked':
                $all_checked = 'checked';
                break;
            case 'set_all_unchecked':
                $all_checked = 'unchecked';
                break;
            case 'filter_ok':
                $selected_table = $_POST['table'];
                break;
            case 'mark_ok':
                if (empty($_POST['checked'])) {
                    $error_msg[] = 'Mark an order, please.';
                    goto render;
                }
                try {
                    $this->db->beginTransaction();
                    foreach ($_POST['checked'] as $c) {
                        $this->db->setServedOrder($c);
                    }
                    $this->db->commit();
                } catch (Exception $e) {
                    $this->db->rollBack();
                    $this-exception($e);
                }
            default:
                header('Location: /index.php');
                exit;
            }
        }

        render:
        $this->render("../views/index/serve.phtml",
            [
                'all_checked' => $all_checked,
                'selected_table' => $selected_table,
                'orders' => $orders,
                'tables' => $tables,
                'error_msg' => $error_msg
            ]
        );
    }

    public function menuAction()
    {
        $menu = $this->db->selectDishes();

        if (isset($_POST['action']) && $_POST['action'] == 'ok') {
            header('Location: /index.php');
            exit;
        }

        $this->render("../views/index/menu.phtml", ['menu' => $menu]);
    }

    public function takeAction()
    {
        $dishes = $this->db->selectDishes(1);
        $tables = $this->db->selectTables();
        $error_msg = [];

        if (!empty($_POST)) {
            if ($_POST['action'] == 'ok') {
                if (empty($_POST['table'])) {
                    $error_msg[] = 'Select a table, please.';
                    goto render;
                }
                if (array_sum($_POST['count']) == 0) {
                    $error_msg[] = 'Select an order, please.';
                    goto render;
                }
                try {
                    $this->db->beginTransaction();
                    foreach ($_POST['count'] as $k => $v) {
                        for ($i = 1, $j = (int) $v ; $i <= $j; $i++) {
                            $this->db->insertOrder($_POST['table'], $k);
                        }
                    }
                    $this->db->commit();
                } catch (\Exception $e) {
                    $this->db->rollBack();
                    $this->exception($e);
                }
            }
            header('Location: /index.php');
            exit;
        }

        render:
        $this->render("../views/index/take.phtml",
            [
                'dishes' => $dishes,
                'tables' => $tables,
                'error_msg' => $error_msg
            ]
        );
    }

    public function selectAction()
    {
        $this->render("../views/index/select.phtml");
    }

    public function receiptAction()
    {
        $this->render("../views/index/receipt.phtml");
    }
}
?>
