<?php
    $monthly_sales = 0;
    $annual_sales = 0;
    $now_month = date('m');
    $now_year = date('Y');
    $db->select("reservation_list","count(*) as count","DATE(datetime) = CURDATE()");
    $reserved_result = $db->sql;
    $reserved_today = mysqli_fetch_assoc($reserved_result)['count'];

    $sales_sql = "SELECT type,
                        SUM(fp.sales) as sales
                    FROM
                        ((
                            SELECT
                                'monthly' AS type, mol.qty * ml.price AS sales
                            FROM
                                menu_order_list mol
                            INNER JOIN menu_list ml ON
                                ml.menu_id = mol.menu_id
                            WHERE
                                YEAR(mol.date_created) = $now_year AND MONTH(mol.date_created) = $now_month)
                        UNION ALL (
                            SELECT
                                'yearly', mol.qty * ml.price AS sales
                            FROM
                                menu_order_list mol
                            INNER JOIN menu_list ml ON
                                ml.menu_id = mol.menu_id
                            WHERE
                                YEAR(mol.date_created) = $now_year)
                        ) AS fp
                    GROUP BY type";
    $sales = $conn->query($sales_sql);
    while($row = $sales->fetch_assoc()) {
        if ($row['type'] == 'monthly'){
            $monthly_sales = number_format($row['sales']);
        }elseif($row['type'] == 'yearly'){
            $annual_sales = number_format($row['sales']);
        }
    }

    $all_months_sql = "SELECT
                            SUM(IF(MONTH = 'Jan', total, 0)) AS 'Jan',
                            SUM(IF(MONTH = 'Feb', total, 0)) AS 'Feb',
                            SUM(IF(MONTH = 'Mar', total, 0)) AS 'Mar',
                            SUM(IF(MONTH = 'Apr', total, 0)) AS 'Apr',
                            SUM(IF(MONTH = 'May', total, 0)) AS 'May',
                            SUM(IF(MONTH = 'Jun', total, 0)) AS 'Jun',
                            SUM(IF(MONTH = 'Jul', total, 0)) AS 'Jul',
                            SUM(IF(MONTH = 'Aug', total, 0)) AS 'Aug',
                            SUM(IF(MONTH = 'Sep', total, 0)) AS 'Sep',
                            SUM(IF(MONTH = 'Oct', total, 0)) AS 'Oct',
                            SUM(IF(MONTH = 'Nov', total, 0)) AS 'Nov',
                            SUM(IF(MONTH = 'Dec', total, 0)) AS 'Dec'
                        FROM
                            (
                            SELECT
                                MIN(
                                    DATE_FORMAT(mol.date_created, '%b')
                                ) AS MONTH,
                                SUM(mol.qty * ml.price) AS total
                            FROM
                                menu_order_list mol
                            INNER JOIN menu_list ml ON
                                ml.menu_id = mol.menu_id
                            GROUP BY
                                YEAR(mol.date_created),
                                MONTH(mol.date_created)
                            ORDER BY
                                YEAR(mol.date_created),
                                MONTH(mol.date_created)
                        ) AS sale";
    $all_sales = $conn->query($all_months_sql,MYSQLI_USE_RESULT);
    $arr_sales = array();
    $sales_every_month = $all_sales->fetch_row();
?>
<div class="row">
        <!-- Sales (Monthly) Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-bottom-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Sales (Monthly)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₱<?=$monthly_sales?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales (Monthly) Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-bottom-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Sales (Annual)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₱<?=$annual_sales?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Reservation Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-bottom-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Reserved Tables Today</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $reserved_today?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-table fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-bottom-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                No. of Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                                $db->select("users","count(*) as count");
                                $result = $db->sql;
                                $row = mysqli_fetch_assoc($result)['count'];
                                echo $row;
                            ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>