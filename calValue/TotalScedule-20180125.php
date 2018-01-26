<?php

class cal_data
{
    public $s_date="";
    
}

class TotalScedule_20180125
{
    private $d1_all_loan = 12000;
    private $d2_real_rate = 0.18;
    private $d2_real_day_rate = 0.0005;
    private $d3_total_Period = 36;
    private $d4_period_days = 0;  // 0=按自然月还， 1-365=按天数周期还，-1=按后面的还款天表
    private $d5_start_date;
    private $d6_period_amount = 0.0;
    private $d6_period_amount_round = 0;
    private $period_days_array=null;
    private $periodAmounts = array();
    
    public function calPeriodAmount( $all_loan ,$real_rate, $total_Period, $period_days=0, $start_date=null, $period_days_array=null)
    {
        if ( $all_loan < 0 ) { $all_loan = 0; }
        if ( $real_rate< 0 ) { $real_rate = 0; }
        if ( $total_Period < 1 ) { $total_Period = 1; }
        
        $this->d1_all_loan = $all_loan;
        $this->d2_real_rate = $real_rate;
        $this->d2_real_day_rate = $this->d2_real_rate / 360.0;
        $this->d3_total_Period = $total_Period; // 不能小于1
        $this->d4_period_days = $period_days; // 0=按自然月还， 1-365=按天数周期还，-1=按后面的还款天表
        $this->period_days_array = $period_days_array;
        
        date_default_timezone_set("Asia/Shanghai");
        
        // $date=date_create(date("Y-m-d")); // "Y-m-d 2017-01-09 Y n j 2017-1-9" // date_date_set($date,2020,10,15);
        
        $date=date_create_from_format("Y-m-d",$start_date);
        if ( $date == false )
        { // 如果没有传递开始日期，或者错误的开始日期，则设置当前日期为开始日期
            $date=date_create(date("Y-m-d")); // "Y-m-d 2017-01-09 Y n j 2017-1-9" // date_date_set($date,2020,10,15);
        }
        
        $this->d5_start_date= date_create_from_format("Y-m-d H:i:s",date_format($date,"Y-m-d 00:00:00"));
        
        unset($this->periodAmounts);
        $this->periodAmounts =array();
        
        $this->periodAmounts[0] = new PeriodAmount_20180125();
        $this->periodAmounts[0]->setPeriodDate($this->d5_start_date,0);
        $this->periodAmounts[0]->setPeriodPrincipal($this->d1_all_loan);
        
        for ($x=1; $x <= $this->d3_total_Period; $x++)
        {
            $this->periodAmounts[$x] = new PeriodAmount_20180125();
            $this->periodAmounts[$x]->setPeriodDate($this->d5_start_date, $x, $this->d4_period_days, $this->period_days_array);       // 赋值借款日和本期还款日、本期期数
            $this->periodAmounts[$x]->fixDueDays($this->periodAmounts[$x-1]->getPeriodDate()); // 修正本期天数
            $this->periodAmounts[$x]->fix_z_1_B($this->d2_real_day_rate);
        }
        
        $this->periodAmounts[$this->d3_total_Period+1] = new PeriodAmount_20180125(); // 多生成一个，data_due_z_1_B = 1；
        
        $sum_z_pai = 0; // 从 2 到 第 25 个 z_pai 求和
        
        for ($x=$this->d3_total_Period; $x >= 1; $x--)
        {
            $mult_pai = $this->periodAmounts[$x+1]->get_z_pai();
            $this->periodAmounts[$x]->set_z_pai( $mult_pai );
            $sum_z_pai = $sum_z_pai + $mult_pai; // 从 2 到 第 25 个 z_pai 求和
        }
        
        $first_z_pai = $this->periodAmounts[1]->get_z_pai(); //  第1 个 z_pai
        $this->d6_period_amount = $this->d1_all_loan * $first_z_pai / $sum_z_pai; // 求精确月供
//        $this->d6_period_amount_round = round( $this->d6_period_amount, 2, PHP_ROUND_HALF_UP ); // 求四舍五入到分月供
        $this->d6_period_amount_round = round( ceil($this->d6_period_amount *100) / 100, 2, PHP_ROUND_HALF_UP ); // 求向上取整到分月供
        
        
        for ($x=1; $x <= $this->d3_total_Period; $x++) {
            $this->periodAmounts[$x]->cal_principal_interest($this->periodAmounts[$x-1]->getNextPeriodPrincipal(),$this->d2_real_day_rate,$this->d6_period_amount_round);
        }
        
        $this->periodAmounts[$this->d3_total_Period]->cal_last_period_due_principal();
        
    }
    
    public function echoTable( $need_table=false )
    {
        if (  $need_table )
        {
            $echoStr = "<table border=1 cellspacing=0 cellpadding=0>\n";
            for ($x=0; $x <= $this->d3_total_Period+1; $x++) {
                $echoStr = $echoStr."    <tr>\n";
                if (isset($this->periodAmounts[$x]))
                {
                    $echoStr = $echoStr.$this->periodAmounts[$x]->echoData(true);
                }
                else {
                    $echoStr = $echoStr."    <td>no data</td>\n";
                }
                $echoStr = $echoStr."    </tr>\n";
            }
            $echoStr = $echoStr."</table>\n";
        } else {
            $echoStr = "{";
            for ($x=0; $x <= $this->d3_total_Period+1; $x++) 
            {
                if (isset($this->periodAmounts[$x]))
                {
                    $echoStr = $echoStr.$this->periodAmounts[$x]->echoData(false);
                    $echoStr = $echoStr.",";
                }
                else {

                }
            }
            
            $echoStr = substr($echoStr,0,strlen($echoStr)-1 )."}";

        }
        return $echoStr;
    }
    
    
    public function calPeriodMount_old() // 这个函数不用了，弃用
    {
        // 这个函数不用了，弃用
        $d5_pow = 0.0;          // 没用了
        
        date_default_timezone_set("Asia/Shanghai");
        
        $period_days = $this->d4_period_days;
        if ( $period_days <= 0 ) // 如果还款周期天数小于0，则改为30天
        {
            $period_days = 30;
        }
        
        $d5_pow = pow( 1 + $this->d2_real_rate * $period_days / 360.0 , $this->d3_total_Period );
        $this->d6_period_amount = $this->d1_all_loan * $this->d2_real_rate * $period_days / 360.0 * $d5_pow / ($d5_pow - 1);
        $this->d6_period_amount_round = round( $this->d6_period_amount, 2, PHP_ROUND_HALF_UP );
        
        $date=date_create(date("Y-m-d")); // "Y-m-d 2017-01-09 Y n j 2017-1-9" // date_date_set($date,2020,10,15);
        $this->d5_start_date= date_create_from_format("Y-m-d H:i:s",date_format($date,"Y-m-d 00:00:00"));
        
        unset($this->periodAmounts);
        $this->periodAmounts =array();
        
        $this->periodAmounts[0] = new PeriodAmount_20180125();
        $this->periodAmounts[0]->setPeriodDate($this->d5_start_date,0);
        $this->periodAmounts[0]->setPeriodPrincipal($this->d1_all_loan);
        
        for ($x=1; $x <= $this->d3_total_Period; $x++) {
            $this->periodAmounts[$x] = new PeriodAmount_20180125();
            $this->periodAmounts[$x]->setPeriodDate($this->d5_start_date,$x);  // 赋值借款日和本期还款日、本期期数
            $this->periodAmounts[$x]->fixDueDays($this->periodAmounts[$x-1]->getPeriodDate()); // 修正本期天数
            $this->periodAmounts[$x]->cal_principal_interest($this->periodAmounts[$x-1]->getNextPeriodPrincipal(),$this->d2_real_rate,$this->d6_period_amount_round);
        }
        
        echo "<table border=1 cellspacing=0 cellpadding=0>\n";
        for ($x=1; $x <= $this->d3_total_Period; $x++)
        {
            echo "    <tr>\n";
            $this->periodAmounts[$x]->echoData();
            echo "    </tr>\n";
        }
        echo "</table>\n";
    }
}
?>