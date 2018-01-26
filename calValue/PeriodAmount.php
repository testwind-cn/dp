<?php


class PeriodAmount
{
    private $data_period_num = 0;
    //    private $data_start_date;// = date_create();        // 贷款首期借款日期
    private $data_last_date;// = date_create();         // 贷款上期还款日期
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
        //        $this->data_start_date = date_create();
        $this->data_last_date = date_create();
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
        $new_interest = $new_principal * ( $this->data_z_1_B - 1) ;  // 本期精确应还利息取整 ;之前是 / 360.0
        $new_interest_round = round( $new_interest, 2, PHP_ROUND_HALF_UP );     // 本期应还利息取整
        
        $this->data_due_interest_real = $new_interest;
        $this->data_due_interest = $new_interest_round;                         // 本期应还利息取整
        
        if ($new_interest_round < $per_amount_round)
            $this->data_due_principal = $per_amount_round - $new_interest_round;
        else
            $this->data_due_principal = 0;
        
        if ($this->data_due_principal > $this->data_period_principal) // 修正本期应还本金，如果应还本金，大于剩余本金，就是错误，改为剩余本金。
        {
            $this->data_due_principal = $this->data_period_principal;
        }
        $this->data_due_amount = $this->data_due_principal + $this->data_due_interest;
    }
    
    public function cal_period_dueday_interest($real_day_rate)
    { // 修正某期应还利息，按天。
        $new_interest = $this->data_period_principal * $this->data_due_days * $real_day_rate;  // 本期精确应还利息取整 ;之前是 / 360.0
        $new_interest_round = round( $new_interest, 2, PHP_ROUND_HALF_UP );     // 本期应还利息取整
        
        $this->data_due_interest_real = $new_interest;
        $this->data_due_interest = $new_interest_round;    // 本期应还利息取整
        
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
    
    
    public function setPeriodDate($start_date,$last_date, $x, $period_days=0, $period_days_array=null)
    {
        $this->data_period_num = $x; //设置这是第几期的编号
        //        $this->data_start_date  = date_create_from_format("Y-m-d H:i:s",date_format($start_date,"Y-m-d 00:00:00"));
        $this->data_last_date = date_create_from_format("Y-m-d H:i:s",date_format($last_date,"Y-m-d 00:00:00"));
        $this->data_period_date = date_create_from_format("Y-m-d H:i:s",date_format($start_date,"Y-m-d 00:00:00"));
        
        
        if ( $x <= 0 ) {
            return;
        }
        
        if ($period_days > 0) // 如果是大于0.则是按天
        {
            $xd = $x * $period_days;
            $per_Int = new DateInterval("P" . $xd . "D");
            
            $this->data_period_date = date_add($this->data_period_date, $per_Int);
            
            
        } else { // 如果是0，则是按半月还，间隔为x个半月.
            if ( $period_days <= 0 && $period_days >= - 24 ) // 如果是-1..-24，则是按月还，间隔为-period_days月.
            {
                $theday1 = getdate($start_date->getTimestamp());
                
                
                
                ////////////// 1) 借款日31号的，首月之后调整到1号
                // 2： 按月的，借款日31号的，往后挪一天到1号，之后按月加，不用调整；首月多借了一天
                if ( $theday1['mday'] == 31 && ($period_days<0 || ($x % 2==0) ) )  // 按月，按半月x是双数的
                {
                    if ($x > 0) // 第2月开始平移到1号
                        date_add($this->data_period_date, new DateInterval("P1D"));
                }
                ////////////// 1)
                
                
                
                ////////////// 2) 加 x 或者 (x+1)/2 、 (x-1)/2 个月
                if ($period_days < 0)
                    $xd = $x * (- $period_days); // 月还, 从首月，增加 x * per 个月
                    else { // 半月还, 从首月，增加 x /2 个月
                        if ($x % 2 == 0) // 半月，双数
                            $xd = $x / 2;
                            if ($x % 2 == 1) // 半月，单数
                            {
                                if ($theday1['mday'] >= 16) // 半月，单数，16号以后的
                                    $xd = ($x + 1) / 2;
                                    else // 半月，单数，15号以前的
                                        $xd = ($x - 1) / 2;
                            }
                    }
                    
                    
                    $per_Int = new DateInterval("P" . $xd . "M");
                    date_add($this->data_period_date, $per_Int);
                    
                    ////////////// 2)
                    
                    
                    ////////////// 3) 半月，单数，15号以前，增加15天
                    
                    if ($period_days == 0 && ($x % 2==1) && ( $theday1['mday'] <= 15 ) )// 半月，单数，15号以前的，<=15号的，就加（x-1）/2个月，再加15天，再修正29,30
                        date_add($this->data_period_date,  new DateInterval("P15D"));
                        ////////////// 3)
                        
                        
                        ////////////// 4) N月还，或者：半月，双数，或者：半月，单数，15号以前，修正 29,30号起始日的
                        //// 半月 单数  14,15需要修正
                        $fixNum1 = $theday1['mday']; // 首期的开始日
                        if ( $period_days < 0 ||($x % 2==0) || ( $fixNum1 <= 15 ) )
                        {
                            if (  $period_days == 0 && ($x % 2==1) && ( $fixNum1 == 14 || $fixNum1 == 15 ) )
                            {
                                // $theday2 = getdate( $this->data_period_date->getTimestamp() );
                                $fixNum1 = $fixNum1 + 15;
                            }
                            if ($fixNum1 == 29 || $fixNum1 == 30)
                            {
                                $aa = $this->fix29_30($this->data_period_date, $fixNum1 );
                                $this->data_period_date = $aa;
                                
                            }
                        }
                        ////////////// 4)
                        
                        
                        ////////////// 5) 半月，单数，>=16号的，就加（x+1）/2个月，再减15天，修正到day-15
                        if ( $period_days == 0 && ( ($x % 2==1) && ( $theday1['mday'] >= 16 ) ) )
                        {
                            date_sub($this->data_period_date,  new DateInterval("P15D"));
                            $theday2 = getdate( $this->data_period_date->getTimestamp() );
                            $this->data_period_date = date_create_from_format("Y-m-d H:i:s",$theday2['year']."-".$theday2['mon']."-".($theday1['mday']-15)." 00:00:00");
                        }
                        ////////////// 5)
                        
                        
            } elseif ($period_days < - 24) // 需要采用后面的实际天数数组
            {
                $sumDays = 0;
                // int t_period_days_array[] = (int[]) period_days_array;
                if (isset($period_days_array))
                    for ($i = 0; $i < $x && $i < count($period_days_array); $i ++) {
                        if (isset($period_days_array[$i]))
                            $sumDays += $period_days_array[$i];
                    }
                $per_Int = new DateInterval("P" . $sumDays . "D"); // 日期加sumDays个天
            }
        }
        
        //    echo date_format($date,"Y/m/d")."<br>";
        // $this->data_due_days = (int) date_diff($this->data_period_date,$this->data_last_date)->format("%a");  //这个没用了，后面需要重新 FixDueDays
        $this->fixDueDays($last_date);
        
        
        return;
    }
    
    public function fix29_30( $thedate, $num )
    {
        $thedate = date_create_from_format("Y-m-d H:i:s",date_format($thedate,"Y-m-d 00:00:00"));
        $theday2 = getdate( $thedate->getTimestamp() );
        
        // 1：  借款日29号的，按月加，如果结果日不等于29（就是1），就减一天
        if ( $num == 29 )
        {
            if ( $theday2['mday'] != 29 )
                $thedate = date_sub( $thedate,new DateInterval("P1D"));
        }
        // 3：  借款日30号的，day=30时, 先按月加，如果结果日不等于30，回到1号，如果是上月是闰月29，再减一天到2月29
        if ( $num == 30 )
        {
            if ( $theday2['mday'] != 30 )
            {
                // echo  date_format( date_create_from_format("Y-m-d", "2009-2-15"),"Y-m-d H:i:s" ); //会把当前时分秒带进去，
                $thedate = date_create_from_format("Y-m-d H:i:s",$theday2['year']."-".$theday2['mon']."-"."1 00:00:00");
                
                $temp_date = date_create_from_format("Y-m-d H:i:s",date_format($thedate,"Y-m-d 00:00:00"));
                date_sub( $temp_date, new DateInterval("P1D"));
                $theday3 = getdate( $temp_date->getTimestamp() );
                
                if ( $theday3['mday'] == 29 )
                    $thedate = $temp_date;
                    // 3：  借款日30号的，day=30时, 先按月加，如果结果日不等于30，回到1号，如果是上月是闰月29，再减一天到2月29
            }
        }
        return $thedate;
    }
    
    
    public function getPeriodDate()
    { // 获取本期还款日的一个副本
        $date= date_create_from_format("Y-m-d H:i:s",date_format($this->data_period_date,"Y-m-d 00:00:00"));
        return $date;
    }
    
    private function fixDueDays($date)
    { // 计算本期还款日和某日期（上期还款日）间隔的天数
        $this->data_due_days = (int) date_diff($this->data_period_date,$date)->format("%a");
    }
    
    
    public function fix_z_1_B($real_day_rate, $per_day,$useSelfDay = false)
    {
        if ( $useSelfDay ) {
            $this->data_z_1_B = 1 + $this->data_due_days * $real_day_rate; // real_rate / 360.0;
        } else  {
            if ( $per_day > 0 ){
                $this->data_z_1_B = 1 + $per_day * $real_day_rate;
            }
            if ( $per_day == 0 ){
                $this->data_z_1_B = 1 + 15 * $real_day_rate;
            }
            if ( $per_day < 0 ){
                $this->data_z_1_B = 1 + 30 * ( -$per_day) * $real_day_rate;
            }
        }
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
            //            $echoStr = $echoStr."        <td>".date_format($this->data_start_date,"Y-m-d")."</td>\n";
            $echoStr = $echoStr."        <td>".date_format($this->data_last_date,"Y-m-d")."</td>\n";
            $echoStr = $echoStr."        <td>".date_format($this->data_period_date,"Y-m-d")."</td>\n";
            $echoStr = $echoStr."        <td>".$this->data_period_principal."</td>\n";
            $echoStr = $echoStr."        <td>".$this->data_due_days."</td>\n";
            $echoStr = $echoStr."        <td>".$this->data_due_principal."</td>\n";
            $echoStr = $echoStr."        <td>".$this->data_due_interest."</td>\n";
            $echoStr = $echoStr."        <td>".$this->data_due_amount."</td>\n";
            $echoStr = $echoStr."        <td>".$this->data_z_1_B."</td>\n";
            $echoStr = $echoStr."        <td>".$this->data_z_pai."</td>\n";
            $echoStr = $echoStr."\n";
        }
        else{
            $arr = array(
                'period_num'=> $this->data_period_num,
                'data_last_date' => date_format($this->data_last_date,"Y-m-d"),
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
            
            $echoStr =  $arr_json; //."<br>\n";
            
            // $obj = json_decode($arr_json);
            // $echoStr =  $obj->{'start_date'}."<br>\n"; // 12345
        }
        
        return $echoStr;
    }
    
    
    
    
    

    
    
}
?>