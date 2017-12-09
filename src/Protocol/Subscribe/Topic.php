<?php

declare(strict_types=1);

namespace unreal4u\MQTT\Protocol\Subscribe;

use unreal4u\MQTT\Exceptions\InvalidQoSLevel;

/**
 * When the client wants to subscribe to a topic, this is done by adding a topic filter.
 *
 * This class allows the client to
 */
final class Topic
{
    /**
     * The 1st byte can contain some bits
     *
     * The order of these flags are:
     *
     *   7-6-5-4-3-2-1-0
     * b'0-0-0-0-0-0-0-0'
     *
     * Bit 7-4: Control packet value ID (3 for PUBLISH)
     * Bit 3: Duplicate delivery of a PUBLISH Control Packet
     * Bit 2 & 1: PUBLISH Quality of Service
     * Bit 0: PUBLISH Retain flag
     *
     * @see http://docs.oasis-open.org/mqtt/mqtt/v3.1.1/os/mqtt-v3.1.1-os.html#_Table_2.2_-
     * @var string
     */
    private $topicName = '';

    /**
     * The QoS lvl, choose between 0 and 2
     * @var int
     */
    private $qosLevel = 0;

    /**
     * Topic constructor. If
     * @param string $topicName
     * @param int $qosLevel
     * @throws \unreal4u\MQTT\Exceptions\InvalidQoSLevel
     * @throws \InvalidArgumentException
     */
    public function __construct(string $topicName, int $qosLevel = 0)
    {
        $this
            ->setTopicName($topicName)
            ->setQoSLevel($qosLevel);
    }

    /**
     * Contains the name of the Topic Filter
     *
     * @param string $topicName
     * @return Topic
     * @throws \InvalidArgumentException
     */
    private function setTopicName(string $topicName): Topic
    {
        if ($topicName === '') {
            throw new \InvalidArgumentException('Topic name must be set');
        }

        $this->topicName = $topicName;

        return $this;
    }

    /**
     * Requested QoS level is the maximum QoS level at which the Server can send Application Messages to the Client
     *
     * @param int $qosLevel
     * @return Topic
     * @throws \unreal4u\MQTT\Exceptions\InvalidQoSLevel
     */
    private function setQoSLevel(int $qosLevel): Topic
    {
        if ($qosLevel > 2 || $qosLevel < 0) {
            throw new InvalidQoSLevel('The provided QoS level is invalid');
        }

        $this->qosLevel = $qosLevel;

        return $this;
    }

    /**
     * @return string
     */
    public function getTopicName(): string
    {
        return $this->topicName;
    }

    /**
     * @return int
     */
    public function getTopicQoSLevel(): int
    {
        return $this->qosLevel;
    }
}
