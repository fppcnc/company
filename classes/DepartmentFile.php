<?php

class DepartmentFile extends Department
{

    /**
     * @return DepartmentFile
     * @throws Exception
     */
    public
    function getAllAsObjects(): array|null
    {
        try {
            if (!is_file(CSV_PATH_DEPARTMENT)) {
                fopen(CSV_PATH_DEPARTMENT, 'w');
            }
            $handle = fopen(CSV_PATH_DEPARTMENT, 'r');
            $departments = [];
            while ($content = fgetcsv($handle, null, ',')) {
                $departments[] = new DepartmentFile($content[0], $content[1]);
            }
            fclose($handle);
        } catch (Error $d) {
            throw new Exception($d->getMessage() . ' ' . $d->getFile() . ' ' . $d->getCode() . ' ' . $d->getLine());
        }
        return $departments;
    }

    /**
     * @param int $id
     * @return DepartmentFile
     * @throws Exception
     */
    public
    function getObjectById(int $id): DepartmentFile
    {
        $departments = $this->getAllAsObjects();
        $department = new DepartmentFile();
        foreach ($departments as $d) {
            if ($d->getId() === $id) {
                $department = $d;
            }
        }
        return $department;
    }


    /**
     * @return void
     * @throws Exception
     */
    public function updateObject(): void
    {
        $departments = $this->getAllAsObjects();
        foreach ($departments as $key => $department) {
            if ($department->getId() === $this->id) {
                $departments[$key] = $this;
                break;
            }
        }
        $this->storeInFile($departments);
    }

    /**
     * @param array $departments
     * @return void
     * @throws Exception
     */
    private function storeInFile(array $departments): void
    {
        try {
            unlink(CSV_PATH_DEPARTMENT);
            $handle = fopen(CSV_PATH_DEPARTMENT, 'w');
            foreach ($departments as $department) {
                $depAssoArray = (array)$department;
                $depNumArray = array_values($depAssoArray);
                fputcsv($handle, $depNumArray, ',');
            }
            fclose($handle);
        } catch (Error $d) {
            throw new Exception($d->getMessage() . ' ' . $d->getFile() . ' ' . $d->getCode() . ' ' . $d->getLine());
        }
    }

    /**
     * @param int $id
     * @return void
     * @throws Exception
     */
    public function delete(int $id): void
    {
        $departments = $this->getAllAsObjects();
        foreach ($departments as $key => $department) {
            if ($department->getId() === $id) {
                unset($departments[$key]);
            }
        }
        $this->storeInFile($departments);
    }

    /**
     * @param string $name *
     * @return DepartmentFile
     * @throws Exception
     */
    public function createNewObject(string $name): DepartmentFile
    {
        if (!is_file(CSV_PATH_ID_DEPARTMENT_COUNTER)) {
            file_put_contents(CSV_PATH_ID_DEPARTMENT_COUNTER, 1);
        }
        $id = file_get_contents(CSV_PATH_ID_DEPARTMENT_COUNTER);
        $d = new DepartmentFile($id, $name);
        $departments = $d->getAllAsObjects();
        $departments[] = $d;
        $d->storeInFile($departments);
        file_put_contents(CSV_PATH_ID_DEPARTMENT_COUNTER, $id + 1);
        return new DepartmentFile();
    }

}

