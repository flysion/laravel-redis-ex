<?php

namespace Lee2son\RedisEx;

trait MutexLock
{
    /**
     * 互斥锁，如果锁被占用则直接返回
     * @param $key string 锁的key
     * @param callable $handle 如果锁未被占用则调用此方法
     * @param $expire int 锁过期时间，单位：秒，过期之后自动解锁
     * @throws \Throwable
     * @return array(locked:bool, return:mixed)
     */
    public function mutexLock($key, callable $handle, $expire = 120) {
        $key = "lock:{$key}";

        if(!$this->setIfNotExists($key, "1", $expire)) {
            return ['locked' => false, 'return' => null];
        }

        try {
            $result = call_user_func($handle);
            $this->del($key);
            return ['locked' => true, 'return' => $result];
        } catch (\Throwable $e) {
            $this->del($key);
            throw $e;
        }
    }

    /**
     * 设置一个key 的值，如果它不存在的话
     *
     * @param string $key
     * @param string $value
     * @param int $expire
     * @return mixed
     */
    abstract public function setIfNotExists(string $key, string $value, int $expire);
}