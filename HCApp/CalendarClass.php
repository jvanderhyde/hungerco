<?php
/*****************************************
CalendarClass.php
Copyright 2007- Akihiro Asai. All rights reserved.

http://aki.adam.ne.jp
aki@ullr.cc
*****************************************/
//Modified by Daisuke Mori, 22 February 2013

class CalendarClass {

    // 全般的な書式の設定
    /** @var string $style_table カレンダー本体のスタイル */
    var $style_table = 'style="width:840px; border-collapse:collapse; border:1px solid #cccccc; font-size:90%"';

    /** @var string $style_table カレンダータイトルのスタイル */
    var $style_title = 'style="text-align:center; background-color:#333333; color:#ffffff"';

    /** @var string $style_table カレンダー曜日名のスタイル */
    var $style_weekname = 'style="text-align:center; width:120px; border:1px solid #cccccc"';

    /** @var string $style_table カレンダー日付枠のスタイル */
    var $style_body = 'style="text-align:right; vertical-align:top; height:100px; border:1px solid #cccccc;"';

    /** @var string $style_table カレンダー日付ブロックのスタイル */
    var $style_day = 'style="margin:0px; padding:0px; text-align:right"';

    // 背景色の設定
    /** @var string $bgcolor_weekname 背景色:曜日名 */
    var $bgcolor_weekname = "#eeeeee";

    /** @var string $bgcolor_weekday 背景色:平日 */
    var $bgcolor_weekday = "#ffffff";

    /** @var string $bgcolor_saturday 背景色:土曜日 */
    var $bgcolor_saturday = "#ddddff";

    /** @var string $bgcolor_holiday 背景色:日祝日 */
    var $bgcolor_holiday = "#ffdddd";

    /** @var string $bgcolor_other 背景色:当月以外の日 */
    var $bgcolor_other = "#eeeeee";

    /** @var array $weekname 曜日名部分の文字列 */
    var $weekname = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");

    // データ表示用
    var $_data;

    // リンク設定用
    var $_link;
    
    // for Volunteer Opportunity text
    var $_volopp;
    
    // for Volunteer Opportunity link form
    var $_volopplink;

   /**
    * コンストラクタ(PHP5対応)
    *
    */
    function __construct()
    {
    }

    /**
     * コンストラクタ
     */
    function CalendarClass()
    {
        return $this->__construct();
    }

    /**
     * カレンダー表示用に作成されたHTML結果を取得する
     *
     * @param int $year 年
     * @param int $month 月
     * @param int $week_start カレンダー左端の曜日(0:日曜日～6:土曜日)
     * @param int $disp_flg 当月以外の日を表示するか(0:表示しない 1:表示する)
     * @param int $holiday_flg 祝日名を表示するか(0:表示しない 1:表示する)
     *
     */
    function getCalendar($year, $month, $week_start = 0, $disp_flg = 0, $holiday_flag = 0)
    {
        // 年月のチェック
        if(checkdate($month, 1, $year) === false) {
            return false;
        }

        // 色設定用の配列を作成
        $bgcolor_weekname = array(
            $this->bgcolor_holiday,
            $this->bgcolor_weekname,
            $this->bgcolor_weekname,
            $this->bgcolor_weekname,
            $this->bgcolor_weekname,
            $this->bgcolor_weekname,
            $this->bgcolor_saturday,
             );
        $bgcolor_body = array(
            $this->bgcolor_holiday,
            $this->bgcolor_weekday,
            $this->bgcolor_weekday,
            $this->bgcolor_weekday,
            $this->bgcolor_weekday,
            $this->bgcolor_weekday,
            $this->bgcolor_saturday,
             );

        
        // 休日情報を取得
        $holiday = $this->getHoliday($year, $month);
        

        // 曜日の開始位置を取得
        $from = 1;
        while(date("w", mktime(0, 0, 0, $month, $from, $year)) !=$week_start ) {
            $from--;
        }

        $beforelast = date("t", mktime(0, 0, 0, $month - 1, 1, $year)); // 前月最終日
        $thislast = date("t", mktime(0, 0, 0, $month, 1, $year)); // 今月最終日
        $textmonth = date("M", mktime(0, 0, 0, $month, 1, $year));
        $lpy = ceil(($thislast + abs($from) + 1) / 7); // Y方向ループ数

        // ----- HTML生成開始 -----
        $html = "";
        $html .= "<table {$this->style_table} summary=\"カレンダー\">\n";

        // ヘッダ
        $html .= "    <tr>\n";
        $html .= "        <td colspan=\"7\" {$this->style_title}>{$textmonth} {$year}</td>";
        $html .= "    </tr>\n";

        // 曜日
        $html .= "    <tr>\n";
        for($i = 0; $i < 7; $i++) {
            $id = ($week_start + $i) % 7;
            $html .= "        <td {$this->style_weekname} bgcolor=\"{$bgcolor_weekname[$id]}\">{$this->weekname[$id]}</td>\n";
        }
        $html .= "    </tr>\n";

        for($i = 0; $i < $lpy; $i++) {

            $html .= "    <tr>\n";

            for($j = 0; $j < 7; $j++) {

                $day = $i * 7 + $j + $from;

                // 背景色セット
                $id = ($week_start + $j) % 7;
                $bgcolor = $bgcolor_body[$id];

                if($day < 1) {
                    // 指定月の前月
                    $dd = $beforelast + $day;
                    $data = $this->_getData($year, $month-1, $dd);
                    $volopp = $this->_getVolopp($year, $month-1, $dd);
                    $bgcolor = $this->bgcolor_other;
                } elseif($day > $thislast) {
                    // 指定月の後月
                    $dd = $day - $thislast;
                    $data = $this->_getData($year, $month+1, $dd);
                    $volopp = $this->_getVolopp($year, $month+1, $dd);
                    $bgcolor = $this->bgcolor_other;
                } else {
                    // 指定月
                    $dd = $day;
                    $data = $this->_getData($year, $month, $dd);
                    $volopp = $this->_getVolopp($year, $month, $dd);
                    $link = $this->_getLink($year, $month, $dd);
                    if($link != "") {
                        $dd = "<a href=\"{$link}\">{$dd}</a>";
                    }

                    
                    // 祝日の色変更処理
                    if(isset($holiday[$day])) {
                        $bgcolor = $this->bgcolor_holiday;
                    }
                    
                }

                // 当月以外の日付を表示しない
                if($disp_flg != 1 && ($day < 1 || $day > $thislast)) {
                    $dd = "&nbsp;";
                    $data = "";
                    $volopp="";
                }

                $html .= "        <td {$this->style_body} bgcolor=\"{$bgcolor}\">\n";
                $html .= "            <p {$this->style_day}>{$dd}</p>\n";

                
                // 休日名出力用追加処理
                if($holiday_flag == 1 && isset($holiday[$day])) {
                    $html .= "            <p>{$holiday[$day]}</p>\n";
                }
                

                if($data != "") {
                    $html .= "            {$data}\n";
                }
                
                if($volopp != "") {
                    $html .= "            {$volopp}\n";
                }
                $html .= "        </td>\n";
            }

            $html .= "    </tr>\n";

        }
        $html .= "</table>\n";

        return $html;
    }

    /**
     * 指定日付にデータをセットする
     *
     * @param int $year
     * @param int $month
     * @param int $day
     * @param string $data
     */
    function setData($year, $month, $day, $data)
    {
        $id = sprintf("%04d%02d%02d", $year, $month, $day);
        $this->_data[$id] = $data;
    }

    /**
     * 指定日付にリンクをセットする
     *
     * @param int $year
     * @param int $month
     * @param int $day
     * @param string $link
     */
    function setLink($year, $month, $day, $link)
    {
        $id = sprintf("%04d%02d%02d", $year, $month, $day);
        $this->_link[$id] = $link;
    }


    /**
     * 指定日付よりデータを取得する
     *
     * @param int $year
     * @param int $month
     * @param int $day
     * @return string
     */
    function _getData($year, $month, $day)
    {
        $id = sprintf("%04d%02d%02d", $year, $month, $day);
        if(isset($this->_data[$id])) {
            return $this->_data[$id];
        }
        return;
    }

    /**
     * 指定日付よりリンクを取得する
     *
     * @param int $year
     * @param int $month
     * @param int $day
     * @return string
     */
    function _getLink($year, $month, $day)
    {
        $id = sprintf("%04d%02d%02d", $year, $month, $day);
        if(isset($this->_link[$id])) {
            return $this->_link[$id];
        }
        return;
    }

    
    /**
     * $year, $month で指定された年月の休日情報を配列で戻します。
     *
     * @param int $year
     * @param int $month
     */
    function getHoliday($year, $month) {

        $ret = array();

        // その月の最初の月曜日が何日かを算出
        $day = 1;
        while(date("w",mktime(0 ,0 ,0 , $month, $day, $year)) != 1) {
            $day++;
        }

        /*
        // 祝日をセット
        switch($month){

            case 1:
                // 元旦
                $ret[1] = "元旦";

                // 成人の日
                if($year < 2000) {
                    $ret[15] = "成人の日";
                } else {
                    $ret[$day+7] = "成人の日";
                }
                break;

                case 2:
                    // 建国記念日
                    $ret[11] = "建国記念日";
                break;

                case 3:
                    // 春分の日
                    if($year > 1979 && $year < 2100) {
                        $tmp = floor(20.8431+($year-1980)*0.242194-floor(($year-1980)/4));
                        $ret[$tmp] = "春分の日";
                    }
                break;

                case 4:
                    // 天皇誕生日 or みどりの日
                    if($year < 1989) {
                        $ret[29] = "天皇誕生日";
                    } elseif($year < 2007) {
                        $ret[29] = "みどりの日";
                    } else {
                        $ret[29] = "昭和の日";
                    }
                break;

                case 5:
                    // 憲法記念日
                    $ret[3] = "憲法記念日";

                    // みどりの日
                    if($year > 2006) {
                        $ret[4] = "みどりの日";
                    }

                    // 子どもの日
                    $ret[5] = "子供の日";
                break;

                case 7:
                    // 海の日
                    if($year > 2002) {
                        $ret[$day+14] = "海の日";
                    } elseif($year > 1994) {
                        $ret[21] = "海の日";
                    }
                break;

                case 9:
                    // 敬老の日
                    if($year < 2003) {
                        $ret[15] = "敬老の日";
                    } else {
                        $ret[$day+14] = "敬老の日";
                    }

                    // 秋分の日
                    if($year > 1979 && $year < 2100) {
                        $tmp = floor(23.2488+($year-1980)*0.242194-floor(($year-1980)/4));
                        $ret[$tmp] = "秋分の日";
                    }
                    break;

                case 10;
                    // 体育の日
                    if($year < 2000) {
                        $ret[10] = "体育の日";
                    } else {
                        $ret[$day+7] = "体育の日";
                    }
                    break;

                case 11:
                    // 文化の日
                    $ret[3] = "文化の日";

                    // 勤労感謝の日
                    $ret[23] = "勤労感謝の日";
                break;

                case 12:
                    // 天皇誕生日
                    if($year > 1988) {
                        $ret[23] = "天皇誕生日";
                    }
                    break;
        }

        // 国民の休日をセット
        if($year > 1985) {
            for($i = 1;$i < date("t",mktime(0, 0, 0, $month, 1, $year)); $i++) {
                if(isset($ret[$i]) && isset($ret[$i+2])) {
                    $ret[$i+1] = "国民の休日";
                    $i = $i + 3;
                }
            }
        }

        // 振り替え休日をセット
        $sday = $day - 1;
        if($sday == 0) {
            $sday = 7;
        }
        for($i = $sday;$i < date("t",mktime(0, 0, 0, $month, 1, $year));$i = $i + 7) {
            // 2008/2/27 変更
            // if(isset($ret[$i])) {
            //     $ret[$i+1] = "振替休日";
            // }
            $j = $i;
            while(isset($ret[$j])) {
                $j++;
            }
            // 2008/3/20 修正
            if(date("w",mktime(0, 0, 0, $month, $j, $year)) > 0) {
                $ret[$j] = "振替休日";
            }
        }
        */
        
        return $ret;
    }
    
    function setVolunteerOpportunity($joinedopp, $resource, $link){
        $numRes=mysql_numrows($resource);
            for($i=0; $i<$numRes; $i++){
                $date=mysql_result($resource,$i,"Date");
                $oppname=mysql_result($resource,$i,"Oppname");
                $oppnum=mysql_result($resource,$i,"Oppnum");
                $this->setOpportunityDay($date, $oppname, $oppnum, $link, in_array($oppnum, $joinedopp));
            }
    }
    
    function setOpportunityDay($date, $oppname, $oppnum, $link, $registered){
        $year=date('Y',strtotime($date));
        $month=date('m',strtotime($date));
        $id=date('Ymd',strtotime($date));
        if(strtotime(date('Y-m-d'))>strtotime($date)){
            $opp="$oppname<br/>";
        }
        else if($registered){
            $opp="<img border=\"0\" src=\"../images/1540_16.png\" width=\"16\" height=\"16\" alt=\"check the box\">
                    $oppname<br/>";
        }
        else{
            $opp="<a href=\"#\" onclick=\"document.opp$oppnum.submit();return false;\" > $oppname</a><br/>";
            $form="<form name=\"opp$oppnum\" action=$link method=\"POST\">
                        <input type=\"hidden\" name=\"year\" value=$year>
                        <input type=\"hidden\" name=\"month\" value=$month>
                        <input type=\"hidden\" name=\"oppnum\" value=$oppnum>
                    </form>";
            $this->_voloppform[$id]=isset($this->_voloppform[$id])?$this->_voloppform[$id].$form:$form;
        }
        $this->_volopp[$id]=isset($this->_volopp[$id])?$this->_volopp[$id].$opp:$opp;
    }
    
    function _getVolopp($year, $month, $day)
    {
        $id = sprintf("%04d%02d%02d", $year, $month, $day);
        if(isset($this->_volopp[$id])) {
            $text=$this->_volopp[$id];
            return isset($this->_voloppform[$id])?$text.$this->_voloppform[$id]:$text;
        }
        return;
    }
}
?>