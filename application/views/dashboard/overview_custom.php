<?php


// tot income exp calculation
$total_expense = 0;
$total_income = 0;
$cat_inc_exp_chart = '';
foreach ($qry_expense->result() as $qry_expense_res) {
    $total_expense += $qry_expense_res->amount;
}
foreach ($qry_income->result() as $qry_income_res) {
    $total_income += $qry_income_res->amount;
}
// tot income exp calculation end

// cat wise calculation
$cat_array_profit = array(); // array for profit % of category

$cat_array_inc_exp = array();

$qry_cat = $this->db->get_where('category', array('status' => 1, 'parent_id' => 0));
foreach ($qry_cat->result() as $qry_cat_res) {
    $exp_cat_tot = 0;
    $inc_cat_tot = 0;
    foreach ($qry_expense->result() as $qry_cat_exp_res) {
        if ($qry_cat_exp_res->category == $qry_cat_res->id) {
            $exp_cat_tot += $qry_cat_exp_res->amount;
        }
    }
    foreach ($qry_income->result() as $qry_cat_inc_res) {
        if ($qry_cat_inc_res->category == $qry_cat_res->id) {
            $inc_cat_tot += $qry_cat_inc_res->amount;
        }
    }

    $exp_cat_child_tot = 0;
    $inc_cat_child_tot = 0;
    $qry_cat_child = $this->db->get_where('category', array('status' => 1, 'parent_id' => $qry_cat_res->id));

    foreach ($qry_cat_child->result() as $qry_cat_child_res) {
        foreach ($qry_expense->result() as $qry_cat_exp_res) {
            if ($qry_cat_exp_res->category == $qry_cat_child_res->id) {
                $exp_cat_child_tot += $qry_cat_exp_res->amount;
            }
        }
        foreach ($qry_income->result() as $qry_cat_inc_res) {
            if ($qry_cat_inc_res->category == $qry_cat_child_res->id) {
                $inc_cat_child_tot += $qry_cat_inc_res->amount;
            }
        }
        //$cat_inc_exp_chart .= "{ y: '" . $qry_cat_child_res->name . "(" . $qry_cat_res->name . ")', a: " . $exp_cat_child_tot . ", b: " . $inc_cat_child_tot . " },";
    }

    $exp_cat_tot += $exp_cat_child_tot;
    $inc_cat_tot += $inc_cat_child_tot;

    $cat_array_inc_exp_temp = '';
    $cat_array_inc_exp_temp = array('exp' => $exp_cat_tot, 'inc' => $inc_cat_tot);
    $cat_array_inc_exp[$qry_cat_res->name] = $cat_array_inc_exp_temp; // array for cat wise inc and exp

//                    category wise profit percentage from income and expense
    $x = $inc_cat_tot;
    $y = $exp_cat_tot;
    $p = $x - $y;
    if ($p >= 0) {
        if ($x != 0)
            $pp = ($p * 100) / $x;
        else
            $pp = 0;
    } else {
        if ($y != 0)
            $pp = ($p * 100) / $y;
        else
            $pp = 0;
    }
    $cat_array_profit[$qry_cat_res->name] = $pp; // calculate and add to cat wise profit array
//                    category wise profit percentage from income and expense end


    $cat_inc_exp_chart .= "{ y: '" . $qry_cat_res->name . "', a: " . $exp_cat_tot . ", b: " . $inc_cat_tot . " },";
}


?>

<div class="col-md-6 col-sm-6 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Income Vs Expense (%) - <?php echo date('F-Y'); ?></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>

                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content col-md-12">
            <!---->
            <div id="echart_pie" style="height:350px;"></div>
            <input type="hidden" value="<?php echo $total_expense; ?>"
                   id="total_expense">
            <input type="hidden" value="<?php echo $total_income; ?>"
                   id="total_income">
            <div class="clearfix"></div>
            <h3>
                <?php echo '<span class="label label-warning"> Expense : - ' . $this->cart->format_number($total_expense) . '</span>'; ?>
            </h3>
            <h3>
                <?php echo '<span class="label label-success"> Income : - ' . $this->cart->format_number($total_income) . '</span>'; ?>
            </h3>
            <h3>
                <?php
                $profit = $total_income - $total_expense;
                if ($profit < 0)
                    echo '<span class="label label-info"> Estimated Profit : <strong style="color: red;">'
                        . $this->cart->format_number($profit) . '</strong></span>';
                else
                    echo '<span class="label label-info" > Estimated Profit : <strong style="color: green;">' . $this->cart->format_number($profit) . '</strong></span>';
                ?>
            </h3>
        </div>
    </div>
</div>

<div class="col-md-6 col-sm-6 col-xs-12" style="max-height: 550px; overflow: auto;">
    <div class="x_panel">
        <div class="x_title">
            <h2>Notes - <?php echo date('F-Y'); ?></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content col-md-12">

            <!-- start accordion -->
            <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">


                <?php

                foreach ($qry_notes->result() as $qry_notes_res) {

                    echo ' 
                                                      <div class="panel">
                                                        <a class="panel-heading" role="tab" id="note_head_' . $qry_notes_res->id . '" data-toggle="collapse"
                                                           data-parent="#accordion" href="#note_' . $qry_notes_res->id . '" aria-expanded="false"
                                                           aria-controls="note_' . $qry_notes_res->id . '">
                                                            <h4 class="panel-title">' . $qry_notes_res->title . ' <small>(' . $qry_notes_res->date . ' ' . $qry_notes_res->time . ')</small></h4>
                                                        </a>
                                                        <div id="note_' . $qry_notes_res->id . '" class="panel-collapse collapse" role="tabpanel"
                                                             aria-labelledby="note_head_' . $qry_notes_res->id . '">
                                                            <div class="panel-body">
                                                            
                                                            ' . $qry_notes_res->title . ' 
                                                            <hr />
                                                            ' . $qry_notes_res->details . ' 
                                                            <hr />
                                                            
                                                            ' . $qry_notes_res->status . ' 
                                                            
                                                            <br />
                                                            
                                                             created: ' . $this->m_config->get_user_name_by_id($qry_notes_res->created_by)
                        . '(' . date_format(date_create($qry_notes_res->created_dt), "d-M-Y h:i A") . ')
                    
                                                            </div>
                                                        </div>
                                                      </div>
                                                  ';
                }

                ?>

                </table>

            </div>
            <!-- end of accordion -->

        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Category wise Expense and Income - <?php echo date('F-Y'); ?></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>

                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content col-md-12">
            <div id="cat-expense-income"></div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Category wise Profit % - <?php echo date('F-Y'); ?>
                <small>From based on income and expense</small>
            </h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>

                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content col-md-12">

            <div class="row">

                <?php

                foreach ($cat_array_profit as $key => $value) {
                    echo '<div class="col-xs-2">
                                            <div style="text-align: center;"> ' . $key . '</div>
                                            <br/>
                                            <span class="chart" data-percent="' . $value . '">
                                                      <span class="percent">' . $value . '</span>
                                            <canvas height="110" width="100%"></canvas></span>
                                        </div>';
                }

                ?>


            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function () {

        Morris.Bar({
            element: 'cat-expense-income',
            data: [

                <?php

                echo $cat_inc_exp_chart;

                ?>
            ],
            xkey: 'y',
            ykeys: ['a', 'b'],
            labels: ['Expense', 'Income'],
            barRatio: 0.4,
            barColors: ['#ff9421', '#1f8e15'],
            xLabelAngle: 0,
            resize: true
        });
    });
</script>