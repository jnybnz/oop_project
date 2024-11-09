<?php

class EmployeeRoster {
    private array $roster;

    public function __construct(int $rosterSize) {
        $this->roster = array_fill(0, $rosterSize, null);
    }

    public function add(Employee $e): void {
        foreach ($this->roster as $index => $employee) {
            if ($employee === null) {
                $this->roster[$index] = $e;
                echo "Employee added at position " . ($index + 1) . "\n";
                return;
            }
        }
        echo "Roster is full! Cannot add more employees.\n";
    }

    public function remove(int $employeeNumber): void {
        $index = $employeeNumber - 1;
        if (isset($this->roster[$index]) && $this->roster[$index] !== null) {
            echo "Removing Employee at position " . $employeeNumber . ":\n";
            echo $this->roster[$index] . "\n";  // Automatically calls __toString()
            $this->roster[$index] = null;
            echo "Employee removed successfully.\n";
        } else {
            echo "Invalid employee number or employee already removed.\n";
        }
    }

    public function count(): int {
        return count(array_filter($this->roster, fn($employee) => $employee !== null));
    }

    public function countCE(): int {
        return count(array_filter($this->roster, fn($employee) => $employee instanceof CommissionEmployee));
    }

    public function countHE(): int {
        return count(array_filter($this->roster, fn($employee) => $employee instanceof HourlyEmployee));
    }

    public function countPE(): int {
        return count(array_filter($this->roster, fn($employee) => $employee instanceof PieceWorker));
    }

    public function display(): void {
        echo "--- ʟɪꜱᴛ ᴏꜰ ᴇᴍᴘʟᴏʏᴇᴇꜱ ---\n\n";
        foreach ($this->roster as $index => $employee) {
            if ($employee !== null) {
                echo "Employee #" . ($index + 1) . "\n";
                echo "Name       : " . $employee->getName() . "\n"; // Use getter
                echo "Address    : " . $employee->getAddress() . "\n"; // Use getter
                echo "Age        : " . $employee->getAge() . "\n"; // Use getter
                echo "Company    : " . $employee->getCompanyName() . "\n"; // Use getter
                echo "Type       : " . (get_class($employee) === 'CommissionEmployee' ? 'Commission' : (get_class($employee) === 'HourlyEmployee' ? 'Hourly' : 'Piece Worker')) . "\n";
                echo "------------------------------\n\n";
            } else {
                echo "Employee #" . ($index + 1) . ": Empty Slot\n";
            }
        }
    }
    

    public function displayCE(): void {
        echo "--- ᴄᴏᴍᴍɪꜱꜱɪᴏɴ ᴇᴍᴘʟᴏʏᴇᴇꜱ ---\n";
        foreach ($this->roster as $employee) {
            if ($employee instanceof CommissionEmployee) {
                echo $employee . "\n";  // Automatically calls __toString()
            }
        }
    }

    public function displayHE(): void {
        echo "--- Hourly Employees ---\n";
        foreach ($this->roster as $employee) {
            if ($employee instanceof HourlyEmployee) {
                echo $employee . "\n";  // Automatically calls __toString()
            }
        }
    }

    public function displayPE(): void {
        echo "--- Piece Workers ---\n";
        foreach ($this->roster as $employee) {
            if ($employee instanceof PieceWorker) {
                echo $employee . "\n";  // Automatically calls __toString()
            }
        }
    }

    public function payroll(): void {
        echo "--- Payroll for All Employees ---\n";
        foreach ($this->roster as $employee) {
            if ($employee !== null) {
                echo $employee . " - Earnings: $" . $employee->earnings() . "\n";  // Automatically calls __toString()
            }
        }
    }
}


?>
