<?php
/*************************************************************************
    > @文件名:     cache.php
    > @作者:       unasm
    > @邮件:       1264310280@qq.com
    > @创建时间:   2013-10-08 13:40:37
 ************************************************************************/
/**
 * 缓存创建类，这里是memcache的缓存
 * 本来打算首先设定一个抽象类，然后之后所有的类集成，最后通过工厂模式决定，不过，
 * 算是，目前先简单一点，直接完成memcache类，完成memcache的基础，如果将来需要添加其他的缓存，再说
 *
 * 是不是有吐槽的欲望，因为实在太短了，内容
 *
 * 只有两个函数，因为缓存的时间限制，所以没有必要删除，增加的时候，或许需要考虑下覆盖的问题
 *  @function test protected
 *  @function store
 *  @function get
 */
class CI_Cache
{
    static $cache,$time;
    /**
     *这是作为对static静态类型的测试和检验吧，感觉这样更好一些
     */
    function __construct()
    {
        $this->cache = new Memcache;
        $this->cache->connect("127.0.0.2",11211);
        $this->time = 180;
    }
    /**
     * 测试使用的函数
     */
    protected function test()
    {
        var_dump($this->cache);
    }
    /**
     * 读取数据的函数
     *
     * 通过提供的索引查找数据，如果查找失败，返回false，成功则返回值
     *
     * @$idx 索引
     * @return bool/value
     */
    public function get($idx)
    {
        $ans = $this->cache->get($idx);
        if($ans){
            return $ans;
        }
        return false;
    }
    /**
     * store保存缓存进行的
     *
     * 将数据保存起来，设置成为不压缩，然后在time的时间内有效，time由__construct确定
     *
     * @$idx 索引
     *
     * @$val 要保存的数据，或许是数据，或许是单个的变量
     */
    public function store($idx ,$val)
    {
        $this->cache->set($idx,$val,0,$this->time);
    }
    /**
     * 更新缓存信息
     *
     * 将数据进行更新,但是一般感觉没有必要呢
     */
    public function update($idx,$val)
    {
        $this->cache->replace($idx,$val,0,$this->time);
    }
}
?>
