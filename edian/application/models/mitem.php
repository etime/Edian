<?php
 /**
   * 这里的item对应了mysql的item表，集中了item的所有的操作
   * category "keyi;keyj;keyk;category|"
   * title : 商品信息的标题，也是搜索的主要依据<br><br>
   * content : 主要介绍内容          <br><br>
   * time，最后的发表时间或者是修改时间<br><br>
   * author_id 发表的人的id<br><br>
   * value 通过赞助，评论，浏览添加起来的价值，也是热度的另一称呼<br><br>
   * visitor_num 访问者的数目，将来收钱的依据，会增加少量的values<br><br>
   * price，商品的价格<br><br>
   * img，商品的图片:每件商品或许不止一个图片，所以做成列表的形式，将来通过正则截取,多个图片，会默认首先显示第一个<br><br>
   * keyword 关键字，保存格式为苹果;清苹果;分号隔开，关键字为分区的字和用户自己输入的关键字,搜索的时候通过like对比关键字<br><br>
   * //promise 承诺，货到付款，七日退货，保证正品，急速发货，赠运费险,送货//目前还没有做，以后做吧<br><br>
   * storeNum 库存量，是attr中各个存货量的叠加,减去每个的库存实在是太纠结了，目前先不处理吧,只是减去总的库存<br><br>
   * judgescore float商品评分：没有必要每次都重新计算一遍吧,加起来，然后除以评论数据就是了<br><br>
   * state : 商品状态 0 销售中，1 下架 2 预备中，3,删除过一段时间开始销售<br><br>
   * attr 通过拼成的字符串,表示商品的属性，颜色，分类的,方便商家查找商品
   * attr的解析拼接地方在插入的地方setorderstate,解析在item的formAttr，那是为了显示attr信息，在model/mitem筹备一个model级别的解析，一个做成数组，另一个管理数组
   * <pre>
   *    attr的格式为
   *    2,2,风味,时间,红烧: ,喷香: ,一个月的烤肉: ,两个月的烤肉: |1000,23;1000,23;1000,23;1000,23
   *        //第一个属性，第二个属性，第一个属性的个数，第二个属性的个数,方便数据处理
   *        [红烧,一个月]1000,23(库存和价格)
   *        [红烧,两个月]1000,23
   *        [喷香,一个月]1000,23
   *        [喷香,两个月]1000,23
   *  </pre>
   * @author:        unasm <1264310280@qq.com>
   * @since:         2013-07-23 07:34:43
   * @name:          ../models/item.php
   * @package        model
   */

/**
 * 对应了 item 这个表的所有操作
 * Class Mitem
 * <pre>
 * item 表中的字段和意义：
 *      id            商品的编号
 *      title         商品的标题
 *      detail        商品的详细描述
 *      putawayTime   商品的上架时间
 *      belongsTo     商品所属商店的编号
 *      rating        商店的评分
 *      storeNum      商品的库存量
 *      price         商品的价格
 *      thumbnail     商品的所有缩略图
 *      attr          商品的属性，需要进行编解码
 *      state         商品的一系列状态
 *      sellNum       商品的销售数量
 *      statisfyNum   商品的满意度
 *      deliveryTime  商品的的送货时间（平局值）
 *      mainThumbnail 商品的住缩略图
 *      category      商品所属的分类
 *      briefInfo     商品的简要描述
 *      visitorNum    商品的浏览人数
 * </pre>
 * @author farmerjian<chengfeng1992@hotmail.com>
 * @since 2013-12-31 13:49:52
 */
class Mitem extends Ci_Model {
    static  $pageNum;//每次前端申请的数据条数

    /**
     * 构造函数
     */
    function __construct() {
        parent::__construct();
        $this->pageNum = 30;
        $this->load->config("edian");
        $this->load->model("mwrong");// mwrong就像一个检测机器，有可能出错的地方都需要load
        $this->pageNum = $this->config->item("pageNum");
    }

    /**
     * 通过商品的 itemId 判断一个商品是否存在
     * @param int $itemId 商品的 itemId
     * @return boolean 如果商品存在，返回 true，否则返回 false
     */
    public function isItemExistByItemId($itemId) {
        $itemId = (int)$itemId;
        $sql = "SELECT COUNT(*) FROM item WHERE id = $itemId";
        $res = $this->db->query($sql);
        $res = $res->result_array();
        return count($res) == 0 ? false : true;
    }

    /**
     * $data 数组必须包含以下东西： keyi, keyj, keyk, category，将他们用 "keyi;keyj;keyk;category|" 的格式进行编码，然后返回
     * @prama array $data
     * @return string
     */
    private function _encodeCategory($data) {
        $ans = '';
        $ans .= $data['keyi'] . ';';
        $ans .= $data['keyj'] . ';';
        $ans .= $data['keyk'] . ';';
        $ans .= $data['category'] . '|';
        return $ans;
    }

    /**
     * 对数据库中提取出来的 category 进行解码
     *      keyi           第一级关键字
     *      keyj           第二级关键字
     *      keyk           第三级关键字
     *      category       本店分类
     * @param string $category  数据库中提取出来的字符串
     * @return array            返回的数组，必须使用以上四个单词作为键值
     */
    private function _decode($category) {
        $res = explode(';', $category);
        $ans['keyi'] = $res[0];
        $ans['keyj'] = $res[1];
        $ans['keyk'] = substr($res[2], 0, -1);
        return $ans;
    }

    /**
     * 商店添加商品的函数，必须包含以下信息:
     * <br>    keyi           :     string      商品第一级关键字
     * <br>    keyj           :     string      商品第二级关键字
     * <br>    keyk           :     string      商品第三级关键字
     * <br>    category       :     string      商品在本店中的分类
     * <br> 以上四个需要 encode 之后，存为 item 表中的 category
     * <br>    price          :     float       商品单价
     * <br>    mainThumbnail  :     string      商品主图，一个，保存在 image/"userId"/main
     * <br>    attr           :     string      属性，用特殊的格式编码
     * <br>    storeNum       :     int         库存
     * <br>    thumbnail      :     string      商品图片，多个，用 ';' 分开，保存在 image/"userId"/thumb/big(在 small 中还有一份镜像)
     * <br>    title          :     string      商品名字，一个
     * <br>    detail         :     string      商品详细信息
     * <br>    belongsTo      :     int         所属商店的 id 号码
     *
     * @param array $data
     * @return int 上传的商品的 id 号
     */
    public function addItem($data) {
        // 把分类列表进行编码
        $data['category'] = $this->_encodeCategory($data);

        // 将所有要存入数据库中的数据进行转义
        foreach ($data as $key => $val) {
            $data[$key] = mysql_real_escape_string($val);
        }

        // sql 语句，因为语句太长，添加的字段太长，于是折段写，更加清晰
        $sql = "INSERT INTO item(" .
               "category, price, mainThumbnail, attr, storeNum, thumbnail, title, detail, belongsTo)" .
               " VALUES(" .
               "'$data[category]', " .
               "'$data[price]', " .
               "'$data[mainThumbnail]', " .
               "'$data[attr]', " .
               "'$data[storeNum]', " .
               "'$data[thumbnail]', " .
               "'$data[title]', " .
               "'$data[detail]', " .
               "'$data[belongsTo]'" .
               ")";

        // 调用 CI 的数据库函数
        $this->db->query($sql);

        // 获取当前上传的商品的 id
        $sql = "SELECT last_insert_id()";
        $res = $this->db->query($sql);
        $res = $res->result_array();

        return $res[0]['last_insert_id()'];
    }

    /**
     * 判断 storeId 的商店中有没有商品使用本店分类 category
     * @param string $category
     * @param int $storeId
     * @return boolean
     */
    public function isCategoryUsed($category, $storeId) {
        $sql = "SELECT count(*) FROM item WHERE belongsTo = $storeId && category LIKE '%;$category|'";
        $res = $this->db->query($sql);
        $res = $res->result_array();
        //$res = $this->$this->db->query($sql)->result_array();//为了纪念，留下了
        return $res[0]['count(*)'] == 0 ? false : true;
    }

    /**
     * 对一个attr属性的时候进行解码
     * <code>2,2,风味,时间,红烧: ,喷香: ,一个月的烤肉: ,两个月的烤肉: |1000,23;1000,23;1000,23;1000,23"</code>
     * <pre>
     * 样例
     *array(2) {
     *  ["storePrc"]=> array(2) {
     *      [0]=> array(1) {
     *          [0]=> array(2) { ["store"]=> string(2) "12" ["prc"]=> string(2) "10" }
     *      }
     *      [1]=> array(1) {
     *          [0]=> array(2) { ["store"]=> string(2) "12" ["prc"]=> string(2) "10" }
     *      }
     *  }
     *  ["idx"]=> array(1) {
     *      ["颜色"]=> array(2) {
     *           [0]=> array(2) { ["font"]=> string(6) "佰色" ["img"]=> string(0) "" }
     *           [1]=> array(2) { ["font"]=> string(6) "红色" ["img"]=> string(0) "" }
     *      }
     *  }
     *}
     *</pre>
     */
    private function _oneAttr($attrIdx, $num) {
        $clen = count($attrIdx);
        if($clen == $attrIdx[0] + 2) {
            for ($i = 2, $len = $attrIdx[0] + 2; $i < $len; $i ++) {
                $tmp = explode(':', $attrIdx[$i]);
                $tmpArr['font'] = $tmp[0];
                /*
                if(count($tmp)){
                    $tmpArr['img'] =  $this->formT
                } else {
                    $tmpArr['img'] = '';
                }
                 */
                $tmpArr['img'] = count($tmp)>1 ? $tmp[1] : '';
                $idx[$attrIdx['1']][] = $tmpArr;
            }
            for ($i = 0; $i < $attrIdx[0]; $i ++) {
                $tmp = explode(',', $num[$i]);
                $tmpStore['store'] = $tmp[0];
                $tmpStore['prc'] = count($tmp) > 1 ? $tmp[1] : '';
                $storePrc[$i] = $tmpStore;
            }
            $res['storePrc'] = $storePrc;
            $res['idx'] = $idx;
            return $res;
        }
        return false;
    }

    /**
     * 对两个的attr进行解码
     */
    private function _twoAttr($attrIdx, $num) {
        $clen = count($attrIdx);
        if($clen == ($attrIdx['0'] + $attrIdx['1'] + 4)) {
            //检查与规则是不是相符合；
            for ($i = 4, $len = $attrIdx[0] + 4; $i < $len; $i ++) {
                $tmp = explode(':', $attrIdx[$i]);
                $tmpArr['font'] = $tmp[0];
                $tmpArr['img'] = count($tmp) > 1 ? $tmp[1] : '';
                $idx[$attrIdx['2']][] = $tmpArr;
            }
            for ($i = 4 + $attrIdx[0]; $i < $clen; $i ++) {
                $tmp = explode(':', $attrIdx[$i]);
                $tmpArr['font'] = $tmp[0];
                $tmpArr['img'] = count($tmp) > 1 ? $tmp[1]: '';
                $idx[$attrIdx['3']][] = $tmpArr;
            }
            $cnt = 0;
            for ($i = 0; $i < $attrIdx[0]; $i ++) {
                for ($j = 0; $j < $attrIdx[1]; $j ++) {
                    $tmp = explode(',', $num[$cnt]);
                    $storePrc[$i][$j]['store'] = $tmp[0];
                    $storePrc[$i][$j]['prc'] = count($tmp) > 1 ? $tmp[1] : '';
                }
            }
            $res['storePrc'] = $storePrc;
            $res['idx'] = $idx;
            return $res;
        }
        return false;
    }

    /**
     * 对attr进行解析
     * 传入attr 字符串，传出数组，将attr中包含的内容全部解析出来，方便处理
     * @param string $attr 拼接成为的字符串
     * @param int $itemId 表示商品的主键id
     * @return array
     * @todo 将下面的oneAttr和twoAttr进行具体类型的判断
     * 传入的字符串如下
     *
     * @example 2,2,风味,时间,红烧: ,喷香: ,一个月的烤肉: ,两个月的烤肉: |1000,23;1000,23;1000,23;1000,23
     * <pre>
     * storeprc: array(2) {
     *      [0]=> array(2) {
     *              [0]=> array(2) {
     *                      ["store"]=> string(4) "1000"
     *                      ["prc"]=> string(2) "23"
     *              }
     *              [1]=> array(2) {
     *                      ["store"]=> string(4) "1000"
     *                      ["prc"]=> string(2) "23"
     *               }
     *      }
     *      [1]=> array(2) {
     *          [0]=> array(2) {
     *              ["store"]=> string(4) "1000"
     *              ["prc"]=> string(2) "23"
     *          }
     *          [1]=> array(2) {
     *              ["store"]=> string(4) "1000"
     *              ["prc"]=> string(2) "23"
     *          }
     *      }
     *  }
     * idx: array(2) {
     *      ["风味"]=> array(2) {
     *              [0]=> array(2) {
     *                  ["font"]=> string(6) "红烧" ["img"]=> string(1) " "
     *              }
     *              [1]=> array(2) {
     *                  ["font"]=> string(6) "喷香" ["img"]=> string(1) " "
     *              }
     *      }
     *      ["时间"]=> array(2) {
     *              [0]=> array(2) {
     *                  ["font"]=> string(18) "一个月的烤肉" ["img"]=> string(1) " "
     *              }
     *              [1]=> array(2) {
     *                  ["font"]=> string(18) "两个月的烤肉" ["img"]=> string(1) " "
     *              }
     *      }
     *  }
     *  </pre>
     */
    public function decodeAttr($attr, $itemId) {
        if (! $attr) return '';
        $temp = explode('|', $attr);
        $attrIdx = explode(',', $temp[0]);//将索引关键值保存到attrIdx中
        $num = explode(';', $temp[1]);
        $flag1 = preg_match("/^\d+$/", $attrIdx[1]);
        $flag0 = preg_match("/^\d+$/", $attrIdx[0]);
        if ($flag1 && $flag0) {
            //返回false的情况为长度编码和标准预订的不同
            $res = $this->_twoAttr($attrIdx, $num);
            //对两个的情况进行处理
        } else if ($flag0) {
            $res = $this->_oneAttr($attrIdx, $num);
        } else {
            //报错，出现了问题
            $this->mwrong->insert('在mitem.php/decodeAttr/' .__LINE__. '行两个flag都是0，这种情况不应个出现的，请检查一下,itemId = '.$itemId);
            return false;
        }
        if (! $res) {
            $this->mwrong->insert('在mitem.php/decodeAttr/'.__LINE__.'出现编码不对的情况检查一下,attr : ' . $attr . '，商品的id为 itemId = '.$itemId);
        } else {
            return $res;
        }
    }

    /**
     * 获取商品详细介绍页面的信息
     * <pre>
     * 主要获取以下信息：
     *     title              商品的名字
     *     detail             商品的详情介绍
     *     price              商品价格
     *     belongsTo          商品所属商店的 id
     *     mainThumbnail      商品的主缩略图
     *     satisfyScore       用户对商品的满意度
     *     attr               商品的属性
     *     storeNum           商品的库存
     *     putawayTime        商品的上架时间
     *     orderNum           商品的订单数量
     *</pre>
     *
     * @param int   $itemId 商品的标示id
     * @return bool
     */
    public function getItemInfo($itemId) {
        $sql = "SELECT title, detail, price, belongsTo, mainThumbnail, thumbnail, satisfyScore, attr, storeNum, " .
            "putawayTime FROM item WHERE id = $itemId";
        $itemId = (int)$itemId;
        if ($itemId === 0) {
            return false;
        }
        $res = $this->db->query($sql);
        // 如果没有筛选到相应的商品
        if ($res->num_rows === 0) {
            return false;
        }
        $res = $res->result_array();
        $res = $res[0];
        // 对attr的解码
        $res['attr'] = $this->decodeAttr($res['attr'] , $itemId);
        // 获取相应老板的 userId
        $this->load->model('store');
        $bossId = $this->store->getOwnerIdByStoreId($res['belongsTo']);

        $this->load->model('boss');
        $loginName = $this->boss->getLoginNameByBossId($bossId);

        $this->load->model('user');
        $userId = $this->user->getUserIdByLoginName($loginName);

        if (is_array($res['attr']) && array_key_exists('idx', $res['attr'])) {
            $this->fixAttrImg($res['attr']['idx'], $userId);
        }

        $res['mainThumbnail'] = $this->fixImg($res['mainThumbnail'], $userId, 'main');
        $res['thumbnail'] = $this->formThumb($res['thumbnail'], $userId);
        return $res;
    }

    /**
     *  将attr中的img信息和路径补全
     *  目前在getItemInfo中调用
     *  @param  array   $attr   需要更新修补的数组
     *  @param  int     $bossId 对应的UserId,因为图片的存储和对应的userId相关
     */
    protected function fixAttrImg(&$attr, $userId) {
        foreach ($attr as $key => $value) {
            for ($i = count($value) -1 ; $i >= 0; $i --) {
                $attr[$key][$i]['img'] = trim($value[$i]['img']);
                if ($attr[$key][$i]['img']) {
                    $attr[$key][$i]['img'] = $this->fixImg($attr[$key][$i]['img'], $userId, 'thumb');
                }
            }
        }
    }
    /**
     * 这里完成对img的补充修正
     *
     * @param string    $thumb  在数据库中thumb 的格式编码，是名字的集合
     * @param int       $userId 店铺老板的id
     * @return string   对thumb 完成解码，是数组的集合
     * @author unasm
     */
    protected function formThumb($thumb, $userId) {
        $res = explode('|', $thumb);
        for ($i = 0, $len = count($res); $i < $len ; $i++) {
            $res[$i] = $this->fixImg($res[$i], $userId, 'thumb');
        }
        return $res;
    }

    /**
     * 这里是为了将item的图片补全的函数
     *
     * @param   string  $thumbPath  thumb的名字
     * @param   int     $userId     店铺拥有者的id,图片的存储和老板的id 有关系
     * @param   boolean $big        当为false的时候，给出小图片的路径，大图片的路径为true；
     * @return string 从http开始的完整路径
     * @author unasm
     */
    protected function fixImg($imgName, $userId, $type) {
        $pre = 'image/' . $userId;
        switch ($type) {
            case 'thumb':
                return base_url($pre . '/thumb/small/' . $imgName);
            case 'big' :
                return base_url($pre . '/thumb/big/' . $imgName);
            case 'main':
                return base_url($pre . '/main/' . $imgName);
            case 'detail':
                return base_url($pre . '/detail/' . $imgName);
            case 'mix':
                return base_url($pre . '/mix/' . $imgName);
            default:
                echo "请选择正确的图片类型";
        }
    }

    /**
     * 给商品添加一个访问量
     * @param int $itemId 商品的 itemId
     * @return boolean 如果添加商品的访问量成功，返回 true，否则返回 false
     */
    public function addvisitor($itemId) {
        $itemId = (int)$itemId;
        //没有检验的必要
        /*
        if (! $this->isItemExistByItemId($itemId)) {
            return false;
        }
         */
        $sql = "UPDATE item SET visitorNum = visitorNum + 1 WHERE id = $itemId";
        //update 返回的是true或者是false
        return $this->db->query($sql);
    }
    /**
     * 获取想要添加到订单中的，但是不能从用户端获取的信息
     *
     * @return array
     * @author unasm
     */
    public function getAddInfo($itemId) {
        $itemId = (int)$itemId;
        $res = $this->db->query('SELECT belongsTo, price FROM item WHERE id = ' . $itemId);
        if ($res->num_rows === 0) {
            return false;
        } else {
            $res = $res->result_array();
            return $res[0];
        }
    }
    /**
     * 找到商品对应的 store
     * @param   int     $itemId     商品的 itemId
     * @return  boolean | array     如果商品不存在，返回 false，否则返回商品所属商店的 id
     */
    public function  getMaster($itemId) {
        $itemId = (int)$itemId;
        if ($itemId === 0) {
            return false;
        }
        $sql = "SELECT belongsTo FROM item WHERE id = $itemId";
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            return false;
        } else {
            $res = $res->result_array();
            return $res[0];
        }
    }

    /**
     * 获取商品的title
     * @param int $itemId 商品序列的id
     * @return array/false $res 要不是false，要不是string
     */
    public function getTitle($itemId) {
        $itemId = (int)$itemId;
        if (! $itemId) {
            return false;
        }
        $sql = "SELECT title FROM item WHERE id = $itemId";
        $res = $this->db->query($sql);
        if($res->num_rows === 0) {
            return false;
        } else {
            $res = $res->result_array();
            return $res[0]['title'];
        }
    }

    /**
     *  根据bossId获取用户的商品列表
     *  @param int $bossId  商品所属boss 的id
     *  return array | boolean 成功是数据数组，失败是false
     */
    public function getBgList($bossId) {
        $bossId = (int)$bossId;
        if ($bossId == 0) {
            return false;
        }
        $sql = "SELECT id, title, storeNum, price, state FROM item WHERE belongsTo = $bossId";
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            return false;
        } else {
            $res = $res->result_array();
            return $res;
        }
    }

    private function _fixMainThumbnailPath($belongsTo, $name) {
        $storeId = $belongsTo;
        $this->load->model('store');
        $bossId = $this->store->getOwnerIdByStoreId($storeId);
        $this->load->model('boss');
        $loginName = $this->boss->getLoginNameByBossId($bossId);
        $this->load->model('user');
        $userId = $this->user->getUserIdByLoginName($loginName);
        return base_url('image/' . $userId . '/main/' . $name);
    }

    /**
     * 为订单提供必要的信息
     * @param $itemId
     * @return bool
     */
    public function getOrder($itemId) {
        $sql = 'SELECT title, belongsTo, storeNum, price, mainThumbnail FROM item WHERE id = ' . $itemId;
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            return false;
        } else {
            $res = $res->result_array();
            $res = $res[0];
            $res['mainThumbnail'] = $this->_fixMainThumbnailPath($res['belongsTo'], $res['mainThumbnail']);
            return $res;
        }
    }

    /**
     * 通过商品编号获取商品的详细信息，通过商品 rating 排序
     * @param int $itemId
     * @return boolean | array
     */
    public function getItemByItemId($itemId) {
        $itemId = (int)$itemId;
        if ($itemId === 0) {
            return false;
        }
        $sql = "SELECT title, price, satisfyScore, sellNum, mainThumbnail FROM item WHERE id = $itemId ORDER BY rating";
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            return false;
        } else {
            $res = $res->result_array();
            $res = $res[0];
            $res['id'] = $itemId;
            $res['mainThumbnail'] = $this->_fixMainThumbnailPath($res['mainThmbnail']);
            return $res;
        }
    }

    /**
     * 通过商店编号获取所有商品详细信息，通过商品 rating 排序
     * @param int $storeId
     * @return boolean | array
     */
    public function getItemByStoreId($storeId) {
        $storeId = (int)$storeId;
        if ($storeId === 0) {
            return false;
        }
        $sql = "SELECT id, title, price, satisfyScore, sellNum, mainThumbnail FROM item WHERE belongsTo = $storeId ORDER BY rating";
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            return false;
        } else {
            $res = $res->result_array();
            for ($i = 0, $len = count($res); $i < $len; $i ++) {
                $res[$i]['mainThumbnail'] = $this->_fixMainThumbnailPath($storeId, $res[$i]['mainThumbnail']);
            }
            return $res;
        }
    }

    /**
     * 与本店搜索对应，在商品的标题中搜索
     * @param string $key 要搜索的关键字
     * @param int $storeId 对应的商店的编号
     * @return boolean | array
     */
    public function searchInStore($key, $storeId) {
        $key = mysql_real_escape_string($key);
        $storeId = (int)$storeId;
        if ($storeId === 0) {
            return false;
        }
        $sql = "SELECT id FROM item WHERE belongsTo = $storeId AND (title LIKE '%" . $key . "%' OR category LIKE '%" . $key . "%') ORDER BY id";
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            return false;
        } else {
            $len = (int)$res->num_rows;
            $res = $res->result_array();
            for ($i = 0; $i < $len; $i ++) {
                $res[$i] = $res[$i]['id'];
            }
            return $res;
        }
    }

    /**
     * 通过提供的本店分类搜索商品，需要提供对应的商店编号和待搜索的本店分类
     * @param string $categoryName 分店分类
     * @param int $storeId 商店编号
     * @return boolean | array
     */
    public function selectInStore($categoryName, $storeId) {
        $categoryName = mysql_real_escape_string($categoryName);
        $storeId = (int)$storeId;
        if ($storeId === 0) {
            return false;
        }
        $sql = "SELECT id FROM item WHERE category LIKE '%;" . $categoryName .  "|' AND belongsTo = $storeId";
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            return false;
        } else {
            $len = $res->num_rows;
            $res = $res->result_array();
            for ($i = 0; $i < $len; $i ++) {
                $res[$i] = $res[$i]['id'];
            }
            return $res;
        }
    }
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/


    public function insert($data)
    {
        $data["title"] = addslashes($data["title"]);
        $data["content"] = addslashes($data["content"]);
        $sql = "insert into item(title,content,time,author_id,value,store_num,price,img,keyword,attr,promise) values('$data[title]','$data[content]',now(),'$data[author_id]','$data[value]','$data[store_num]','$data[price]','$data[img]','$data[keys]','$data[attr]','$data[promise]')";
        $res = $this->db->query($sql);
        return $res;
    }

    private function titleFb($res){
        //对title进行反转义
        for($i = 0; $i < count($res);$i++){
            $res[$i]["title"] = stripslashes($res[$i]["title"]);
        }
        return $res;
    }
    /*
    public function getIdByKey($key)
    {
        //这个性能有待考证，不知道对title的查找性能如何,而且，需要explain
        //这个需要四个以上的字做关键词，当调节到2个的时候，可以使用，现在使用like
        $sql = "select id,value from item where MATCH(keyword,title) AGAINST('$key')";
        $res = $this->db->query($sql);
        return $res->result_array();
    }
     */
    /**
     * 为热区的搜索提供数据
     *
     * 提供一个开始的id，然后返回热区需要的数据
     *
     * @$startId 数据的下标
     * @return array
     */
    public function getHot($startId)
    {
        //或许需要缓存，或许需要一个临时的表，这些测试之后再说吧
        $startId = $startId*$this->pageNum;
        $sql = "select id,title,price,author_id,img,visitor_num,judgescore from item where state = 0 order by value desc limit $startId,$this->pageNum";
        $res = $this->db->query($sql);
        $res = $res->result_array();
        $res = $this->titleFb($res);
        for($i = 0,$len = count($res);$i < $len;$i++){
            $temp = $res[$i];
            $temp["img"] = explode("|",$temp["img"]);
            if($temp["img"][0]){
                $res[$i]["img"] = $temp["img"][0];//之后或许可以随机一个出来呢,额，还是算了，这样的话，让别人知道哪个更重要
            }else{
                $res[$i]["img"] = "edianlogo.jpg";
            }
            $temp = $this->db->query("select count(*) from comItem where item_id = $temp[id]");
            $temp = $temp->result_array();
            $res[$i]["comment_num"] = $temp[0]["count(*)"];
        }
        return $res;
    }
    public function getMin($id)
    {
        //通过id获得少量的信息，方便列表页面,订单和评价数通过查询获得
        //对img 进行分割，处理，读取出一张图片
        $sql = "select title,price,author_id,img,visitor_num,judgescore from item where id = $id";
        $res = $this->db->query($sql);
        $res = $res->result_array();
        if(!$res)return false;//如果长度为0，则返回，需要测试
        $res = $this->titleFb($res);
        $res = $res[0];
        $res["img"] = explode("|",$res["img"]);
        if($res["img"][0]){
            $res["img"] = $res["img"][0];
        }else{
            $res["img"] = "edianlogo.jpg";
        }
        $temp = $this->db->query("select count(*) from comItem where item_id = $id");
        $temp = $temp->result_array();
        $res["comment_num"] = $temp[0]["count(*)"];
        return $res;
    }
    public function getUserList($userId)
    {
        //为用户中心提供数据，显示订单数字，评论数,
        $sql = "select id,title,price,author_id,img,visitor_num,judgescore,keyword from item where author_id = $userId && state = 0";
        $res = $this->db->query($sql);
        $res = $res->result_array();
        if(!$res)return false;//如果长度为0，则返回，需要测试
        $res = $this->titleFb($res);
        for($i = count($res)-1;$i >= 0;$i--){
            $temp = $res[$i]["img"];
            $temp = explode("|",$temp);
            if($temp[0]){
                $res[$i]["img"] = $temp[0];
            }else{
                $res[$i]["img"] = "edianlogo.jpg";
            }
            $temp = $this->db->query("select count(*) from comItem where item_id = ".$res[$i]['id']);
            $temp = $temp->result_array();
            $res[$i]["comment_num"] = $temp[0]["count(*)"];
            $temp = $this->db->query("select  count(*) from ord where item_id = ".$res[$i]['id']);
            $temp = $temp->result_array();
            $res[$i]["order_num"] = $temp[0]["count(*)"];
        }
        return $res;
    }

    public function addValue($artId)
    {//为art添加浏览者数目,因为和用户想要的没有太大关系，所以不需要什么返回值,增加value
        $this->db->query("update item set value = value + 10  where art_id = '$artId'");
    }
    public function addComNum($artId)
    {//添加评论者信息，需要给出art_id,评论者id,需要更新new,commer,comment_num,同时增加value
        $this->db->query("update item set value = value+600 where art_id  = '$artId'");
        //大概是增加20分钟的样子，
    }



    public function getIdByKey($key)
    {
        //通过关键字检索查询信息
        $res = $this->db->query("select id,value from item where title like '%$key%' or keyword like '%;$key;%' && state = 0");//关键字的存储要；key；的形式，就是两边都是；，查找的时候，也要两边都是;，这样，匹配出来的，就是完整的关键字
        //只匹配在销售的商品
        return $res->result_array();
    }

    public function getAllList()
    {
        //获得全部的列表，为为后台浏览,管理员 权限
    $res = $this->db->query("select id,title,storeNum,price,state from item");
        if($res){
            $res = $res->result_array();
            return $res;
        }
        return false;
    }
    public function setState($state,$itemId)
    {
        $this->db->query("update item set state = $state where id = $itemId");
    }

    /**
     * 通过id获得对应的价格
     * 对目前对应函数仅仅是order/setorderstate
     * @param int $itemId 获得价格
     */
    public function getPrice($itemId)
    {
        $itemId = (int)$itemId;
        if(!$itemId)return false;
        $res = $this->db->query("select price from item where id = $itemId");
        if($res->num_rows){
            $res = $res->result_array();
            return $res[0]["price"];
        }
        return false;
    }
    /**
     * 在下单之后，修改对应的库存
     *
     * 通过传入的info信息，分解字符串,查找对应的库存信息，然后减去,重新拼接字符串
     * 目前针对的情况为属性只有两个的情况,
     * @param string $info 或许包含|,需要分割的字符串，是物品的可选属性
     * @param int $buyNum 用户购买的数量
     * @param int $itemId  需要修改的商品的id
     * @todo 现在添加了无限商品的功能，将来添加每段时间多少最多销量的功能
     */
    public function changeStore($info,$buyNum,$itemId)
    {
        $infoToSet = $this->db->query("select attr,store_num from item where id = $itemId");
        if($infoToSet->num_rows){
            $infoToSet = $infoToSet->result_array();
            $this->load->config("edian");
            if($this->config->item("maxStoreNum") == $infoToSet[0]["store_num"]){
                //无限库存，不在减去，同时子类也不再减去,不再更新修改
                return true;
            }
            $infoToSet = $infoToSet[0]["attr"];//attr为0的情况
            if($infoToSet){
                $attr = $this->decodeAttr($infoToSet,$itemId);
                $idxNum = $this->getIdx($attr["idx"],$info);
                $len = count($idxNum);
                if($len == 1){
                    $attr["storePrc"][$idxNum[0]]["store"] -= $buyNum;
                }elseif($len == 2){
                    $attr["storePrc"][$idxNum[0]][$idxNum[1]] -= $buyNum;
                }else{
                    $temp["text"] = "在mitem/changeStore/".__LINE__."行出现不应该出现的错误，len = ".$len.
                        "，这不应该出现,attr[idx] = ".$attr["idx"]."itemId = ".$itemId;
                    $this->mwrong->insert($temp);
                }
                $fAttr = $this->formAttr($attr);//最终形成的attr，貌似是正确的
                return $this->db->query("update item set store_num = store_num - ".$buyNum.",attr = '$fAttr' where id = ".$itemId);
            }else{
                return $this->db->query("update item set store_num = store_num - ".$buyNum." where id = $itemId");
                //有没有可能小于0 呢
            }
        }else{
            $temp["text"] = "mitem/changeStore/".__LINE__."行，在itemId = ".$itemId."的情况下没有搜索结果";
            $this->mwrong->insert($temp);
            return false;
        }
        //$this->db->query("update item set store_num where id = $itemId");
    }
    /**
     * 通过传入的idx，构成拼接的字符串
     * @param array $attr attr拆分之后的数组
     * @return string 重新构成的字符串
     *     * idx: array(2) {
     *      ["风味"]=> array(2) {
     *              [0]=> array(2) {
     *                  ["font"]=> string(6) "红烧" ["img"]=> string(1) " ";
     *              }
     *              [1]=> array(2) {
     *                  ["font"]=> string(6) "喷香" ["img"]=> string(1) " "
     *              }
     *      }
     *      ["时间"]=> array(2) {
     *              [0]=> array(2) {
     *                  ["font"]=> string(18) "一个月的烤肉" ["img"]=> string(1) " "
     *              }
     *              [1]=> array(2) {
     *                  ["font"]=> string(18) "两个月的烤肉" ["img"]=> string(1) " "
     *              }
     *      }
     *  }
     */
    protected function formAttr($attr)
    {
        $idx = $this->formIdx($attr["idx"]);
        $store = $this->formStore($attr["storePrc"]);
        return $idx."|".$store;
    }
    /**
     * 构成attr 的前面的一部分 attr属性
     * @param array $idx item/attr字段的构成前面一部分
     * @example 2,2,风味,时间,红烧: ,喷香: ,一个月的烤肉: ,两个月的烤肉: |1000,23;1000,23;1000,23;1000,23
     */
    protected function formIdx($idx)
    {
        $re = "";//属性的内容
        $idxVal = "";//属性的名字
        $num = "";//这个是为了attr之前的数字
        $cnt = 0;
        foreach ($idx as $key => $val) {
            $len = count($val);
            $idxVal = ",".$key;
            if($cnt == 0){
                $num = $len;
                $cnt = 1;
            }else{
                $num .= ",".$len;
            }
            for ($i = 0; $i < $len; $i++) {
                $re .= ",".$val[$i]["font"].":".$val[$i]["img"];
            }
        }
        return $num.$idxVal.$re;
    }
    /**
     * 通过传入的idx数组，得到里面的下标
     * 在修改库存的时候使用，通过对应属性的查找得到对应属性的下标，方便修改库存
     * @param array $idx 包含了各个属性的数组
     * @param string $attr 被选中的属性
     * @return array $res下标，一个，或则是两个
     */
    protected function getIdx($idx,$attr)
    {
        $attr = explode("|",$attr);
        $len = count($attr);
        $cnt = 0;
        $res = array();
        foreach ($idx as $val) {
            if($cnt < $len){
                for ($i = 0,$len = count($val); $i < $len; $i++) {
                    if($attr[$cnt] == $val[$i]["font"]){
                        $res[$cnt] = $i;
                        break;
                    }
                }
            }else{
                $temp["text"] = "mitem/getIdx".__LINE__."行出现bug,cnt超过len,目前数据为idx = ".$idx." attr = ".$attr;
                $this->mwrong->insert($temp);
                return false;
            }
            $cnt++;
        }
        return $res;
    }

    /**
     * 对storeprc的编码
     * <code>2,2,风味,时间,红烧: ,喷香: ,一个月的烤肉: ,两个月的烤肉: |1000,23;1000,23;1000,23;1000,23"</code>
     */
    protected function formStore($storePrc)
    {
        $re = "";
        for ($i = 0,$leni = count($storePrc); $i < $leni; $i++) {
            $istore = $storePrc[$i];
            if(array_key_exists("store",$istore)){
                if($i == 0){
                    $re .= $istore["store"].",".$istore["prc"];
                }else{
                    $re .= ";".$istore["store"].",".$istore["prc"];
                }
            }else{
                for ($j = 0,$lenj = count($istore); $j < $lenj; $j++) {
                    if($re){
                        $re  .= ";".$istore[$j]["store"].",".$istore[$j]["prc"];
                    }else{
                        $re  = $istore[$j]["store"].",".$istore[$j]["prc"];
                    }
                }
            }
        }
        return $re;
    }
}
?>

