<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\DynamicHtmlExport;
use Maatwebsite\Excel\Facades\Excel;
class ReportController extends Controller
{
    public function generateExcelFromHtmlContent(Request $request)
    {
        ob_start()
        ?>
        
        <table border="1" cellpadding="5" cellspacing="0">
            <caption><strong>Employee Data - Table 1</strong></caption>
            <thead>
                <tr>
                    <th>Emp ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Position</th>
                    <th>Department</th>
                    <th>Salary</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Country</th>
                    <th>Postal Code</th>
                    <th>Joining Date</th>
                    <th>Manager</th>
                    <th>Team</th>
                    <th>Performance Rating</th>
                    <th>Training Completed</th>
                    <th>Last Promotion Date</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dummy Data Rows (100+) -->
                <?php for ($i = 1; $i <= 100; $i++) { ?>
                    <tr>
                        <td><?php echo "E" . str_pad($i, 4, '0', STR_PAD_LEFT); ?></td>
                        <td>Employee <?php echo $i; ?></td>
                        <td><?php echo rand(22, 60); ?></td>
                        <td><?php echo rand(0, 1) ? 'Male' : 'Female'; ?></td>
                        <td>employee<?php echo $i; ?>@example.com</td>
                        <td>(555) 555-0<?php echo $i; ?></td>
                        <td><?php echo $i % 2 === 0 ? 'Manager' : 'Developer'; ?></td>
                        <td><?php echo $i % 2 === 0 ? 'HR' : 'Engineering'; ?></td>
                        <td>$<?php echo rand(40000, 100000); ?></td>
                        <td>123 Main St.</td>
                        <td>City <?php echo rand(1, 10); ?></td>
                        <td>State <?php echo rand(1, 5); ?></td>
                        <td>Country <?php echo rand(1, 3); ?></td>
                        <td><?php echo rand(1000, 9999); ?></td>
                        <td>2020-<?php echo rand(1, 12); ?>-<?php echo rand(1, 28); ?></td>
                        <td>Manager <?php echo rand(1, 20); ?></td>
                        <td>Team <?php echo rand(1, 5); ?></td>
                        <td><?php echo rand(1, 5); ?></td>
                        <td><?php echo rand(0, 1) ? 'Yes' : 'No'; ?></td>
                        <td>2022-10-<?php echo rand(1, 28); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <br>

        <!-- Table 2 -->
        <table border="1" cellpadding="5" cellspacing="0">
            <caption><strong>Project Data - Table 2</strong></caption>
            <thead>
                <tr>
                    <th>Project ID</th>
                    <th>Project Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Budget</th>
                    <th>Project Manager</th>
                    <th>Team Size</th>
                    <th>Client Name</th>
                    <th>Client Contact</th>
                    <th>Location</th>
                    <th>Duration</th>
                    <th>Completion Percentage</th>
                    <th>Technology Used</th>
                    <th>Deadline Met</th>
                    <th>Risk Level</th>
                    <th>Priority</th>
                    <th>Department</th>
                    <th>Resources Allocated</th>
                    <th>Client Feedback</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dummy Data Rows (100+) -->
                <?php for ($i = 1; $i <= 100; $i++) { ?>
                    <tr>
                        <td><?php echo "P" . str_pad($i, 4, '0', STR_PAD_LEFT); ?></td>
                        <td>Project <?php echo $i; ?></td>
                        <td>2021-04-<?php echo rand(1, 28); ?></td>
                        <td>2023-04-<?php echo rand(1, 28); ?></td>
                        <td><?php echo rand(0, 1) ? 'Completed' : 'Ongoing'; ?></td>
                        <td>$<?php echo rand(50000, 200000); ?></td>
                        <td>Manager <?php echo rand(1, 20); ?></td>
                        <td><?php echo rand(5, 15); ?></td>
                        <td>Client <?php echo rand(1, 10); ?></td>
                        <td>(555) 555-0<?php echo $i; ?></td>
                        <td>Location <?php echo rand(1, 5); ?></td>
                        <td><?php echo rand(3, 24); ?> months</td>
                        <td><?php echo rand(10, 100); ?>%</td>
                        <td>PHP, Laravel, MySQL</td>
                        <td><?php echo rand(0, 1) ? 'Yes' : 'No'; ?></td>
                        <td><?php echo rand(1, 5); ?></td>
                        <td><?php echo rand(1, 3); ?></td>
                        <td><?php echo rand(1, 3); ?></td>
                        <td><?php echo rand(1, 5); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php

        $content = ob_get_clean();
        ob_clean();
        return Excel::download(new DynamicHtmlExport($content), 'dynamic_content.xlsx');
    }
}
