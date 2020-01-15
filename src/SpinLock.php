<?php

namespace Lee2son\RedisEx;

trait SpinLock
{
    /**
     * 自旋锁，如果锁被占用则等待，直到解锁
     * @param string $key 锁的key
     * @param callable $handle 加锁后的处理函数
     * @param int $expire 锁过期时间，单位：秒，过期之后自动解锁
     * @param int $usleep 如果发现被锁，等待多少us后再次尝试加锁
     * @throws \Throwable
     * @return mixed
     */
    public function spinLock($key, callable $handle, $expire = 120, $usleep = 20e3) {
        $key = "lock:{$key}";

        while(!$this->setIfNotExists($key, "1", $expire)) {
            usleep($usleep);
        }

        try {
            $result = call_user_func($handle);
            $this->del($key);
        } catch (\Throwable $e) {
            $this->del($key);
            throw $e;
        }

        return $result;
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