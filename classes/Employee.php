<?php

// 0p3
abstract class Employee implements Saveable
{
    protected int $id;
    protected string $firstName;
    protected string $lastName;
    protected int $departmentId;


    /**
     * @param int|null $id
     * @param string|null $firstName
     * @param string|null $lastName
     * @param int|null $departmentId
     */
    public function __construct(int|null $id = null, string|null $firstName = null, string|null $lastName = null, int|null $departmentId = null)
    {
        if (isset($id) && isset($firstName) && isset($lastName) && isset($departmentId)) {
            $this->id = $id;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->departmentId = $departmentId;
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return int
     */
    public function getDepartmentId(): int
    {
        return $this->departmentId;
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param int $departmentId
     * @return object
     */
    abstract public function createNewObject(string $firstName, string $lastName, int $departmentId): object;

}