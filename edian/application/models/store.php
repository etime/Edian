<?php
/**
 * 对store进行操作的文件
 * 不同字段的内容作用介绍
 * <pre>
 *      name:         商店的名字
 *      id:           商店在后台对应的唯一id，primary ，主键
 *      topPicture:   商店首部的装饰图片，可选,在考虑要不要放到more中
 *      serviceQQ:    客服QQ
 *      servicePhone: 客服电话
 *      address:      商店的地址
 *      longtitude:   商店所在的经纬度
 *      latitude:     商店所在的经纬度
 *      category:     商店内部商品的分类,所有的分类都保存在一个字段里面，将一维数组以 | 分隔符分开
 *      briefInfo:    商店的自身简介
 *      owerId:       对应的boss中的id，所属者的id
 *      deliveryTime: 商店的送货时间，营业时间
 *      deliveryArea: 送货范围
 *      credit:       商店的评分
 *      more:         保存了不值得单独存储一个字段，但是或许有些店有，有些店没有的东西
 *      state:        标志商店现在的状态，歇业,整顿，修改中,关闭,具体在配置的storeState中定义
 *          0, 修改审核中
 *          1, 正常营业中
 *          2, 歇业
 *          3,关闭
 * </pre>
 * @since 2013-11-24 09:52:12
 * @author farmerjian <chengfeng1992@hotmail.com>
 * @todo store表的credit is wrong ,the biggest num is 0.99,it can't be done
 * @todo 也许我们应该添加一个时间，表示对店铺的注册时间
 *
 */
class Store extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->model("mwrong");
    }

    /**
     * 构成more中的数组
     * 注意，为了实现反转码，必须不能存在 | = 两种字符串
     * @param array $arr 想转化为字符串的一维数组
     */
    protected function encodeMore($arr) {
        $str = "";
        foreach ($arr as $key => $val) {
            if($str)
                $str .= '|' . $key . '=' .$val;
            else
                $str = $key . '=' .$val;
        }
        return $str;
    }

    /**
     * 将more从一个字符串的状态变幻成为数组
     * @param string $str more在数据库中的存储数组
     * @return array
     */
    protected function decodeMore($str) {
        $arr = Array();
        if(!$str)return $arr;
        $tmpArr = explode("|" , $str);
        for($i = 0,$len = count($tmpArr) ; $i < $len; $i++){
            $keyval = explode('=' , $tmpArr[$i]);
            if(count($keyval) === 2 && $keyval[1]){
                //array_push($arr, Array($keyval[0] => $keyval[1]) );
                $arr = array_merge($arr, Array($keyval[0] => $keyval[1]) );
            }else{
                $this->mwrong->insert("model/store/". __LINE__ . "行count的结果大于2，不应该出现,此时对应的参数str = " . $str);
            }
        }
        return $arr;
    }

    /**
     * 根据传入的more在对应的数据库中进行查找更改，修改数据库的more内容
     * 并不在这里插入,之所以这样，首先是想减少一次sql修改，第二，更加灵活吧，交给调用的地方进行处理
     * @param array $more   想要修改的内容
     * @param int   storeId 修改more内容的商店id
     * @return 返回需要插入的字符串
     */
    protected function formMore($more , $storeId) {
        $res = $this->db->query("select more from store where id = ". $storeId);
        $res = $res->result_array();
        $orginMore = $this->decodeMore($res[0]["more"]);
        foreach ($more as $key => $val) {
            if(!$val) continue;//如果没有对应的值更新，不更改，也不添加
            if(array_key_exists($key,$orginMore)){
                $orginMore[$key] = $val;//如果存在，就更新
            }else{
                $orginMore = array_merge($orginMore,Array($key => $val));
            }
        }
        return $this->encodeMore($orginMore);
    }

    /**
     * 修改store信息的时候使用的函数
     * @param   array   $arr     array中的规则是这样的，没一个key对应的都是数据库中的字段名，后面是想更改成的数值
     * @return  boolen          修改成功，或者失败
     * @author  unasm
     * @since   2013-12-13 20:38:16
     */
    public function update($arr, $more, $storeId) {
        $sql = 'update store set ';
        $cnt = false;
        $arr['more'] = $this->formMore($more, $storeId);
        foreach ($arr as $key => $val) {
            if ($val != false) {
                $val = mysql_real_escape_string($val);
                if ($cnt != false) {
                    $cnt .= ', ' . $key . '=' . '\''. $val . '\'';
                } else {
                    $cnt = $key . '=' .'\'' . $val . '\'';
                }
            }
        }
        $sql .= $cnt . ' where id = ' . $storeId;
        return $this->db->query($sql);
    }

    /**
     * 利用提供的 storeId 和 ownerId，判断一个 owner 是否拥有这个 store
     * @param int $storeId 商店 id
     * @param int $ownerId 老板 id
     * @return bool 如果匹配，返回 true，否则返回 false
     */
    public function isMatch($storeId, $ownerId) {
        // 对要匹配的字符进行转义
        $storeId = (int)$storeId;
        $ownerId = (int)$ownerId;
        if ($storeId === 0 || $ownerId === 0) {
            return false;
        }
        $sql = "SELECT count(*) FROM store WHERE id = $storeId && ownerId = $ownerId";
        $res = $this->db->query($sql)->result_array();
        return $res[0]['count(*)'] == 1 ? true : false;
    }

    /**
     * 在判断出 storeId 存在的情况下，提取它的分类列表
     * @param int $storeId
     * @return array
     */
    public function getCategoryByStoreId($storeId) {
        $storeId = mysql_real_escape_string($storeId);
        $sql = "SELECT category FROM store WHERE id = $storeId";
        $res = $this->db->query($sql);
        $res = $res->result_array();
        // 将所有的 category 解码
        $res = explode('|', $res[0]['category']);
        return $res;
    }

    /**
     * 通过拥有者的 Id 获取该拥有者的所有商店的 id 和 name
     * @param int $ownerId
     * @return array
     */
    public function getIdNameByOwnerId($ownerId) {
        $ownerId = (int)$ownerId;
        if ($ownerId === 0) {
            return false;
        }
        $sql = "SELECT id, name FROM store WHERE ownerId = $ownerId";
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            return false;
        } else {
            $res = $res->result_array();
            return $res;
        }
    }

    /**
     * 获取所有商店的编号和名字，仅在 admin 模式下使用
     * @return boolean | array
     */
    public function getIdNameAll() {
        $sql = "SELECT id, name FROM store";
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            return false;
        } else {
            $res = $res->result_array();
            return $res;
        }
    }

    /**
     * 更新商店的本店分类
     * @param string $newCategory
     * @param int $storeId
     */
    public function updateCategoryByStoreId($newCategory, $storeId) {
        $newCategory = mysql_real_escape_string($newCategory);
        $storeId = (int)$storeId;
        $sql = "UPDATE store SET category = '$newCategory' WHERE id = $storeId";
        return $this->db->query($sql);
    }

    /**
     * 通过store信息，为bg/set服务
     */
    public function getSetInfo($storeId) {
        $storeId = (int)$storeId;
        if ($storeId === 0) {
            return false;
        }
        $sql = "SELECT briefInfo, name, logo, sendPrice, serviceQQ, servicePhone, address, longitude, latitude, category, more, deliveryTime, deliveryArea FROM store WHERE id = $storeId";
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            $sql = "在model/store/getSetInfo/中num_rows 位0，有人对不应该存在的storeId进行了索引,storeId = ".$storeId;
            $this->mwrong->insert($sql);
            return false;
        } else {
            $res = $res->result_array();
            $ansArr = $res[0];
            $ansArr['category'] = $this->decodeCategory($ansArr['category']);
            $ansArr['more'] = $this->decodeMore($ansArr['more']);
            return $ansArr;
        }
    }

    /**
     *  对cagegory 进行解码,从字符串变成数组;
     *  @param  string  $category category在数据库中保存成的数组
     *  @return array   对category进行解码形成的数组
     */
    protected function decodeCategory($category) {
        if ($category) {
            return explode('|', $category);
        } else {
            return Array();
        }
    }

    /**
     * 对category进行编码，从数组变成字符串
     * @param array $cateArr    category构成的字符串
     * @return string
     */
    protected function encodeCategory($cateArr) {
        $res = '';
        for ($i = 0, $len = count($cateArr); $i < $len; $i ++) {
            if (! $cateArr[$i]) {
                continue;
            }
            $res .= ($i === 0) ? $cateArr[$i] : ('|' . $cateArr[$i]);
        }
        return $res;
    }

    /**
     * 添加商店的分类
     * @param   string $toAdd     将要添加的商品分类
     * @return  boolen
     */
    public function changeCategory($toAdd, $storeId) {
        $storeId = (int)$storeId;
        if ($storeId === 0) {
            return false;
        }
        $toAdd = mysql_real_escape_string($toAdd);
        $sql = "SELECT category FROM store WHERE id = $storeId";
        $res = $this->db->query($sql);
        if ($res->num_rows != 0) {
            $res = $res->result_array();
            $res = $this->decodeCategory($res[0]['category']);
            // 检验重复性
            foreach ($res as $value) {
                if ($value == $toAdd) {
                    return true;
                }
            }
            array_push($res, $toAdd);
            $str = $this->encodeCategory($res);
            $sql = "UPDATE store SET category = '$str' WHERE id = $storeId";
            return $this->db->query($sql);
        } else {
            $sql = __LINE__."行model/store/changeCategory/查询了一个不存在的storeId,storeId = " . $storeId;
            $this->mwrong->insert($sql);
        }
    }

    /**
     * 插入一个商店的拥有者，相当于为老板新增一个商店
     * @param int $ownerId
     * @return boolean | int
     */
    public function insertStore($ownerId) {
        $ownerId = (int)$ownerId;
        if ($ownerId === 0) {
            $sql = 'model/store/' . __LINE__ . '行出现了不应该出现的bug，ownerId在强制转换之后成为了0';
            $this->mwrong->insert($sql);
            return false;
        }
        $sql = "INSERT INTO store(ownerId) values('$ownerId')";
        $res = $this->db->query($sql);
        if ($res) {
            $sql = 'SELECT last_insert_id()';
            $res = $this->db->query($sql);
            $res = $res->result_array();
            return $res[0]['last_insert_id()'];
        } else {
            return false;
        }
    }

    /**
     * 通过 storeId 获取商店的详细信息
     * 目前已知在商品详情页提供显示的信息
     * <pre>
     * 主要包括以下字段：
     *     name
     *     serviceQQ
     *     servicePhone
     *     address
     *     longitude
     *     latitude
     *     briefInfo
     *     deliveryTime
     *     deliveryArea
     *     sendPrice
     *     logo             unasm add at 2014-01-13 15:12:56   我觉得商品的页面显示下logo比较合适,先加上了
     * </pre>
     * @param int $ownerId 商店的标示id
     * @return boolean | array
     * @todo  经纬度,briefInfo的是否使用，还待商榷
     */
    public function getStoreInfo($ownerId) {
        $sql = 'SELECT name, serviceQQ, servicePhone, address, longitude, latitude, briefInfo, deliveryTime, ' .
            'deliveryArea, sendPrice, logo FROM store WHERE id = ' . $ownerId;
        $res = $this->db->query($sql);
        if ($res->num_rows) {
            $res = $res->result_array();
            $res[0]['logo'] = $this->fixLogoPath($ownerId , $res[0]['logo']);
            return $res[0];
        } else {
            return false;
        }
    }
    /**
     *  将店铺的logo图片进行路径修复
     *  通过storeId获得bossId，通过bossId，获取userId,然后
     *  修复，以后要做一个优化，这样不行
     *  @param  int     $storeId    将店铺的id传入，
     *  @param  string  $imgName    图片的名字
     *  @author unasm
     */
    protected function fixLogoPath($storeId,$imgName)
    {
        $bossId = $this->getOwnerIdByStoreId($storeId);
        $this->load->model('boss');
        $loginName = $this->boss->getLoginNameByBossId($bossId);
        $this->load->model('user');
        $userId = $this->user->getUserIdByLoginName($loginName);
        return base_url('image/' . $userId . '/mix/' . $imgName);
    }
    /**
     * 获取商店的名字和id的列表
     * @param int $bossId 获取某个boss名下的商店列表，-1的时候，对应管理员
     * @return array
     * @author unasm
     */
    public function getStoreList( $bossId = -1 ) {
        $bossId = (int)$bossId;
        if(!$bossId)return false;
        if($bossId === -1){
            $sql = 'SELECT name, id FROM store';
        } else {
            $sql = 'SELECT name ,id FROM store WHERE ownerId = ' . $bossId;
        }
        //$sql = "SELECT name, id FROM store";
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            return false;
        } else {
            return $res->result_array();
        }
    }

    /**
     * 通过商店的 storeId 获取其 ownerId
     * @param $storeId 商店的编号
     * @return boolean | int
     */
    public function getOwnerIdByStoreId($storeId) {
        $storeId = (int)$storeId;
        $sql = "SELECT ownerId FROM store WHERE id = $storeId";
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            return false;
        } else {
            $res = $res->result_array();
            return $res[0]['ownerId'];
        }
    }

    /**
     * 获取商店的起送价格
     * @param int $storeId
     * @return boolean | float
     */
    public function getSendPriceByStoreId($storeId) {
        $storeId = (int)$storeId;
        if ($storeId === 0) {
            return false;
        }
        $sql = "SELECT sendPrice FROM store WHERE id = $storeId";
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            return false;
        } else {
            $res = $res->result_array();
            return $res[0]['sendPrice'];
        }
    }

    /**
     * 获取商店的地图有关信息，主要包括：
     *      longitude       商店经度
     *      latitude        商店维度
     *      deliveryArea    商店送货半径
     *      name            商店名字
     * @param int $storeId  商店编号
     * @return boolean | array 商店相关信息
     */
    public function getStoreMap($storeId) {
        $storeId = (int)$storeId;
        if ($storeId === 0) {
            return false;
        }
        $sql = "SELECT longitude, latitude, deliveryArea, name FROM store WHERE id = $storeId";
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            return false;
        } else {
            $res = $res->result_array();
            return $res[0];
        }
    }

    /**
     * 在商店首页获取的商店信息，主要包轮一下几点：
     * <pre>
     *      deliveryTime    送货时间
     *      deliveryArea    送货区间
     *      credit          商店评分
     *      duration        送货速度
     *      servicePhone    服务电话
     *      serviceQQ       服务QQ
     *      logo            商店 logo
     *      category        本店分类
     * </pre>
     * @param int $storeId 商店编号
     * @return boolean | array 商店信息
     */
    public function getShopInfo($storeId) {
        $storeId = (int)$storeId;
        if ($storeId === 0) {
            return false;
        }
        $sql = "SELECT name, briefInfo, deliveryTime, deliveryArea, credit, duration, servicePhone, serviceQQ, logo, category FROM store WHERE id = $storeId";
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            return false;
        } else {
            $res = $res->result_array();
            $res = $res[0];
            $res['category'] = $this->decodeCategory($res['category']);

            $sql = "SELECT ownerId FROM store WHERE id = $storeId";
            $bossId = $this->db->query($sql);
            $bossId = $bossId->result_array();
            $bossId = $bossId[0]['ownerId'];

            $this->load->model('boss');
            $loginName = $this->boss->getLoginNameByBossId($bossId);

            $this->load->model('user');
            $userId = $this->user->getUserIdByLoginName($loginName);

            $res['logo'] = base_url('image/' . $userId . '/mix/' . $res['logo']);
            return $res;
        }
    }

    /**
     * 获取店铺的状态，为管理员操作服务
     * 管理员权限，所以不需要输入，或者说，目前不需要输入
     */
    public function getStateList() {
        $res = $this->db->query('SELECT name, id ,state , ownerId  FROM store');
        if ($res->num_rows) {
            return $res->result_array();
        } else {
            $this->load->model('mwrong');
            $this->mwrong->insert('model/store/getStateList/' . __LINE__ . '行索引结果为' .$res->num_rows .'， 请检查');
            return false;
        }
    }
    /**
     * 修改店铺的state状态
     * @param int   $storeId    店铺的id
     * @param int   $state      想要修改的店铺的状态
     * @return boolean  update的返回值是一个布尔类型
     */
    public function updateStoreState($storeId,$state) {
        $storeId = (int)$storeId;
        $state = (int)$state;
        return $this->db->query('update store set state =' . $state . ' where id = ' . $storeId);
    }

    /**
     * 获取指定商店编号的平均送货时间
     * @param int $storeId 商店编号
     * @return boolean | int
     */
    public function getDuration($storeId) {
        $storeId = (int)$storeId;
        if ($storeId == 0) {
            return false;
        }
        $sql = "SELECT duration FROM store WHERE id = $storeId";
        $res = $this->db->query($sql);
        if ($res->num_rows == 0) {
            return false;
        } else {
            $res = $res->result_array();
            return $res[0]['duration'];
        }
    }

    /**
     * 获取指定编号商店的商店名字
     * @param int $storeId 商店编号
     * @return boolean | string
     */
    public function getStoreName($storeId) {
        $storeId = (int)$storeId;
        if ($storeId == 0) {
            return false;
        }
        $sql = "SELECT name FROM store WHERE id = $storeId";
        $ans = $this->db->query($sql);
        if ($ans->num_rows == 0) {
            return false;
        } else {
            $ans = $ans->result_array();
            return $ans[0]['name'];
        }
    }
    /**
     * 获取通知店家下单的方式
     */
     public function informInfo($storeId = 0)
     {
         $storeId = (int)$storeId;
         $res = $this->db->query('SELECT servicePhone , more FROM store WHERE id = ' . $storeId);
         if($res->num_rows){
             $res = $res->result_array();
             $res = $res[0];
             $res['more'] = $this->decodeMore($res['more']);
             return $res;
         }
         return false;
     }

    /**
     * 提供给首页附近商店的 5 个商店
     * @author farmerjian<chengfeng1992@hotmail.com>
     * @since 2014-02-25 13:43:34
     */
    public function getStoreInHome() {
        $sql = "SELECT id, name, logo, credit, duration FROM store WHERE state = 1 ORDER BY credit LIMIT 0, 5";
        $ans = $this->db->query($sql);
        if ($ans->num_rows == false) {
            return false;
        } else {
            $ans = $ans->result_array();
            for ($i = 0, $len = (int)count($ans); $i < $len; $i ++) {
                $storeId = $ans[$i]['id'];
                $sql = "SELECT ownerId FROM store WHERE id = $storeId";
                $bossId = $this->db->query($sql);
                $bossId = $bossId->result_array();
                $bossId = $bossId[0]['ownerId'];

                $this->load->model('boss');
                $loginName = $this->boss->getLoginNameByBossId($bossId);

                $this->load->model('user');
                $userId = $this->user->getUserIdByLoginName($loginName);

                $ans[$i]['logo'] = base_url('image/' . $userId . '/mix/' . $ans[$i]['logo']);
            }
            return $ans;
        }
    }

    /**
     * provide data for /shop/queue
     * @return boolean | array
     */
    public function getShopList() {
        $sql = "SELECT id, name, logo, credit, sendPrice, duration FROM store WHERE state = 1 ORDER BY credit LIMIT 0, 8";
        $ans = $this->db->query($sql);
        if ($ans->num_rows == false) {
            return false;
        } else {
            $ans = $ans->result_array();
            for ($i = 0, $len = (int)count($ans); $i < $len; $i ++) {
                $storeId = $ans[$i]['id'];
                $sql = "SELECT ownerId FROM store WHERE id = $storeId";
                $bossId = $this->db->query($sql);
                $bossId = $bossId->result_array();
                $bossId = $bossId[0]['ownerId'];

                $this->load->model('boss');
                $loginName = $this->boss->getLoginNameByBossId($bossId);

                $this->load->model('user');
                $userId = $this->user->getUserIdByLoginName($loginName);

                $ans[$i]['logo'] = base_url('image/' . $userId . '/mix/' . $ans[$i]['logo']);
            }
            return $ans;
        }
    }
}
?>