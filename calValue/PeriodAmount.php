<?php
class PeriodAmount
{
    private $data_period_num = 0;
    private $data_start_date;// = date_create();        // 贷款首期借款日期
    private $data_period_date;// = date_create();       // 贷款本期还款日期
    private $data_period_principal = 0;                 // 本期总欠本金
    private $data_due_days = 0;                         // 本期借款天数
    private $data_due_principal = 0;                    // 本期应还本金
    private $data_due_interest_real = 0.0;              // 本期应还利息_原始小数
    private $data_due_interest = 0.0;                   // 本期应还利息_取整
    private $data_due_amount = 0;                        // 本期应还本息
    private $data_z_1_B = 1;                            // 本期本息率 = 1 + 年率 /360* 本期天数
    private $data_z_pai = 1;                            // <本息率>连乘积
    
    function __construct()
    {
        $this->data_start_date = date_create();
        $this->data_period_date = date_create();
        
    }
    
    public function setPeriodPrincipal($principal)
    { // 设置本期总欠款本金
        $this->data_period_principal = $principal;
    }
    
    public function getNextPeriodPrincipal()
    { // 计算下期总欠款本金
        return $this->data_period_principal - $this->data_due_principal;
    }
    
    public function cal_principal_interest($new_principal,$real_day_rate,$per_amount_round)
    { // 计算本期应还本金、利息、剩余本金。
        $this->data_period_principal = $new_principal;                          // 本期总欠本金
        $new_interest = $new_principal * $this->data_due_days * $real_day_rate ;  // 本期精确应还利息取整 ;之前是 / 360.0
        $new_interest_round = round( $new_interest, 2, PHP_ROUND_HALF_UP );     // 本期应还利息取整
        
        $this->data_due_interest_real = $new_interest;
        $this->data_due_interest = $new_interest_round;                         // 本期应还利息取整
        
        if ( $new_interest_round < $per_amount_round  )
            $this->data_due_principal = $per_amount_round - $new_interest_round;
        else
           $this->data_due_principal = 0;
        
        if ( $this->data_due_principal > $this->data_period_principal ) // 修正本期应还本金，如果应还本金，大于剩余本金，就是错误，改为剩余本金。
        {
            $this->data_due_principal = $this->data_period_principal;
        }
        $this->data_due_amount = $this->data_due_principal + $this->data_due_interest;
    }
    
    public function cal_last_period_due_principal()
    { // 修正最后一期应还本金，如果没还完本金，全部归还。
        if ( $this->data_due_principal < $this->data_period_principal )
        {
            $this->data_due_principal = $this->data_period_principal;
        }
        $this->data_due_amount = $this->data_due_principal + $this->data_due_interest;
    }
    
    public function setPeriodDate($start_date, $x, $period_days=0, $period_days_array=null)
    {
        $this->data_period_num = $x;
        
        if ( $period_days == 0 ) // 如果是0，则是按月还，间隔为x月.
        {
            $per_Int = new DateInterval("P".$x."M");
            
        } elseif ( $period_days < 0 ) // 需要采用后面的实际天数数组
        {
            $sumDays = 0;
          //  int t_period_days_array[] = (int[]) period_days_array;
            if ( isset($period_days_array ) )
            for ( $i=0; $i<$x && $i< count($period_days_array); $i++ ) {
                if (isset($period_days_array[$i]))
                    $sumDays += $period_days_array[$i];
            }
            $per_Int = new DateInterval("P".$sumDays."D"); // 日期加sumDays个天
            
        } else
        {
            $xd = $x * $period_days;
            $per_Int = new DateInterval("P".$xd."D");
        }
        
        $this->data_start_date  = date_create_from_format("Y-m-d H:i:s",date_format($start_date,"Y-m-d 00:00:00"));
        $this->data_period_date = date_create_from_format("Y-m-d H:i:s",date_format($start_date,"Y-m-d 00:00:00"));
        
        
        $this->data_period_date = date_add($this->data_period_date,$per_Int);
        //    echo date_format($date,"Y/m/d")."<br>";
        $this->data_due_days = (int) date_diff($this->data_period_date,$this->data_start_date)->format("%a");  //这个没用了，后面需要重新 FixDueDays
        return;
    }
    
    public function getPeriodDate()
    { // 获取本期还款日的一个副本
        $date= date_create_from_format("Y-m-d H:i:s",date_format($this->data_period_date,"Y-m-d 00:00:00"));
        return $date;
    }
    
    public function fixDueDays($date)
    { // 计算本期还款日和某日期（上期还款日）间隔的天数
        $this->data_due_days = (int) date_diff($this->data_period_date,$date)->format("%a");
    }
    
    public function fix_z_1_B($real_day_rate)
    {
        $this->data_z_1_B = 1 + $this->data_due_days * $real_day_rate; // real_rate / 360.0;
    }
    
    public function get_z_pai()
    {
        return $this->data_z_pai;
    }
    public function set_z_pai($mult_pai)
    {
        $this->data_z_pai = $this->data_z_1_B * $mult_pai;
    }
    
    public function echoData( $need_table=false )
    {
        

        if ( $need_table ) {
            //echo date_default_timezone_get();
            $echoStr = "        <td>".$this->data_period_num."</td>\n";
            $echoStr = $echoStr."        <td>".date_format($this->data_start_date,"Y-m-d")."</td>\n";
            $echoStr = $echoStr."        <td>".date_format($this->data_period_date,"Y-m-d")."</td>\n";
            $echoStr = $echoStr."        <td>".$this->data_period_principal."</td>\n";
            $echoStr = $echoStr."        <td>".$this->data_due_days."</td>\n";
            $echoStr = $echoStr."        <td>".$this->data_due_principal."</td>\n";
            $echoStr = $echoStr."        <td>".$this->data_due_interest."</td>\n";
            $echoStr = $echoStr."        <td>".$this->data_due_amount."</td>\n";
            $echoStr = $echoStr."        <td>".$this->data_z_1_B."</td>\n";
            $echoStr = $echoStr."        <td>".$this->data_z_pai."</td>\n";
            $echoStr = $echoStr."\n";
            return $echoStr;
        }
        else{
            $arr = array(
                'period_num'=> $this->data_period_num,
                'start_date' => date_format($this->data_start_date,"Y-m-d"),
                'period_date' => date_format($this->data_period_date,"Y-m-d"),
                'period_principal' => $this->data_period_principal,
                'due_days' => $this->data_due_days,
                'due_principal' => $this->data_due_principal,
                'due_interest' => $this->data_due_interest,
                'due_amount' => $this->data_due_amount,
                'z_1_B' => $this->data_z_1_B,
                'z_pai' => $this->data_z_pai
                );
            
            $arr_json = json_encode($arr);
            
            echo $arr_json."<br>\n";
            
            $obj = json_decode($arr_json);
            echo $obj->{'start_date'}."<br>\n"; // 12345
        }
    }
    
    
    
}
?>