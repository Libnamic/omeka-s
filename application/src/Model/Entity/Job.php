<?php
namespace Omeka\Model\Entity;

use DateTime;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * @Entity
 * @HasLifecycleCallbacks
 */
class Job extends AbstractEntity
{
    /**#@+
     * Job statuses
     *
     * STATUS_STARTING:    The job was dispatched.
     * STATUS_IN_PROGRESS: The job was sent and is in progress.
     * STATUS_COMPLETED:   The job was performed and is sucessfully completed.
     * STATUS_INCOMPLETE:  The job is incomplete and cannot be restarted.
     * STATUS_PAUSED:      The job was paused and can be restarted.
     * STATUS_ERROR:       There was an unrecoverable error during the job.
     */
    const STATUS_STARTING    = 'starting';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED   = 'completed';
    const STATUS_INCOMPLETE  = 'incomplete';
    const STATUS_PAUSED      = 'paused';
    const STATUS_ERROR       = 'error';
    /**#@-*/

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @Column(nullable=true)
     */
    protected $pid;

    /**
     * @Column(nullable=true)
     */
    protected $status;

    /**
     * @Column
     */
    protected $class;

    /**
     * @Column(type="json_array", nullable=true)
     */
    protected $args;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(onDelete="SET NULL")
     */
    protected $owner;

    /**
     * @Column(type="datetime")
     */
    protected $started;

    /**
     * @Column(type="datetime", nullable=true)
     */
    protected $stopped;

    public function getId()
    {
        return $this->id;
    }

    public function setPid($pid)
    {
        $this->pid = $pid;
    }

    public function getPid()
    {
        return $this->pid;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setClass($class)
    {
        $this->class = $class;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function setArgs($args)
    {
        $this->args = $args;
    }

    public function getArgs()
    {
        return $this->args;
    }

    public function setOwner(User $owner = null)
    {
        $this->owner = $owner;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function setStarted(DateTime $started)
    {
        $this->started = $started;
    }

    public function getStarted()
    {
        return $this->started;
    }

    public function setStopped(DateTime $stopped)
    {
        $this->stopped = $stopped;
    }

    public function getStopped()
    {
        return $this->stopped;
    }

    /**
     * @PrePersist
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $this->started = new DateTime('now');
    }
}
