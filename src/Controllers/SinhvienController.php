<?php
// src/Controllers/SinhvienController.php
namespace Hzjan\Bai01QuanlySv\Controllers;
use Hzjan\Bai01QuanlySv\Models\SinhvienModel;
use Hzjan\Bai01QuanlySv\Core\FlashMessage;

class SinhvienController
{
    private $sinhvienModel;
    public function __construct()
    {
        $this->sinhvienModel = new SinhvienModel();
    }
    // HÀM HELPER ĐỂ XỬ LÝ UPLOAD
    private function handleUpload($file)
    {
        // Kiểm tra lỗi upload file
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $uploadErrors = [
                UPLOAD_ERR_INI_SIZE => 'File vượt quá kích thước tối đa (php.ini).',
                UPLOAD_ERR_FORM_SIZE => 'File vượt quá kích thước tối đa (form).',
                UPLOAD_ERR_PARTIAL => 'File chỉ được upload một phần.',
                UPLOAD_ERR_NO_FILE => 'Không có file được chọn.',
                UPLOAD_ERR_NO_TMP_DIR => 'Thư mục tạm thời bị thiếu.',
                UPLOAD_ERR_CANT_WRITE => 'Không thể ghi file vào đĩa.',
                UPLOAD_ERR_EXTENSION => 'Một tiện ích PHP đã dừng upload.'
            ];
            $errorMsg = $uploadErrors[$file['error']] ?? 'Lỗi upload không xác định.';
            return ['error' => $errorMsg];
        }

        $targetDir = PROJECT_ROOT . "/uploads/avatars/";

        // Kiểm tra và tạo thư mục nếu chưa tồn tại
        if (!is_dir($targetDir)) {
            if (!@mkdir($targetDir, 0755, true)) {
                return ['error' => 'Không thể tạo thư mục upload. Kiểm tra quyền hạn của thư mục uploads.'];
            }
        }

        // Kiểm tra thư mục có writable không
        if (!is_writable($targetDir)) {
            return ['error' => 'Thư mục upload không có quyền ghi. Kiểm tra permissions của ' . $targetDir];
        }

        // Kiểm tra kích thước file
        $maxFileSize = 5 * 1024 * 1024; // 5MB
        if ($file['size'] > $maxFileSize) {
            return ['error' => 'File quá lớn. Kích thước tối đa: 5MB.'];
        }

        // Tạo tên file
        $fileName = uniqid() . '-' . basename($file["name"]);
        $targetFile = $targetDir . $fileName;

        // Lấy loại file
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Kiểm tra định dạng file
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedTypes)) {
            return [
                'error' => 'Chỉ cho phép upload file ảnh (JPG, JPEG, PNG, GIF).'
            ];
        }

        // Kiểm tra MIME type để bảo mật hơn
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file["tmp_name"]);
        finfo_close($finfo);
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($mimeType, $allowedMimes)) {
            return ['error' => 'File không phải là ảnh hợp lệ.'];
        }

        // Di chuyển file
        if (@move_uploaded_file($file["tmp_name"], $targetFile)) {
            // Đặt quyền file
            @chmod($targetFile, 0644);
            return ['filename' => $fileName];
        } else {
            return ['error' => 'Không thể lưu file. Kiểm tra quyền hạn thư mục hoặc dung lượng đĩa.'];
        }
    }
    // Hiển thị danh sách sinh viên
    public function index()
    {
        // --- CÀI ĐẶT CÁC BIẾN PHÂN TRANG ---
        $recordsPerPage = 5; // Số sinh viên mỗi trang
        $currentPage = isset($_GET['page']) ?
            (int) $_GET['page'] : 1;
        if ($currentPage < 1) {
            $currentPage = 1;
        }
        $offset = ($currentPage - 1) * $recordsPerPage;
        $keyword = $_GET['keyword'] ?? null;
        $sortBy = $_GET['sort_by'] ?? 'id';
        $sortOrder = $_GET['sort_order'] ?? 'DESC';
        // --- GỌI MODEL ---
        $result = $this->sinhvienModel->getStudents(
            $keyword,
            $recordsPerPage,
            $offset,
            $sortBy,
            $sortOrder
        );
        $students = $result['data'];
        $totalRecords = $result['total'];
        $totalPages = ceil($totalRecords / $recordsPerPage);
        require_once __DIR__ . '/../Views/sinhvien_list.php';
    }
    // Xử lý thêm sinh viên
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $course = $_POST['course'] ?? '';
            $class_name = $_POST['class_name'] ?? '';
            $major = $_POST['major'] ?? '';
            $avatar = null;
            // Xử lý upload file
            if (
                isset($_FILES['avatar']) &&
                $_FILES['avatar']['error'] == 0
            ) {
                $uploadResult =
                    $this->handleUpload($_FILES['avatar']);

                if (isset($uploadResult['filename'])) {
                    $avatar = $uploadResult['filename'];
                } else {
                    FlashMessage::set(
                        'student_action',
                        $uploadResult['error'],
                        'error'
                    );
                    header('Location: index.php');
                    exit();
                }
            }
            if (
                !empty($name) && !empty($email) && !empty($phone)
            ) {

                $this->sinhvienModel->addStudent(
                    $name,
                    $email,
                    $phone,
                    $course,
                    $class_name,
                    $major,
                    $avatar
                );
                FlashMessage::set('student_action', 'Thêm sinh viên thành công!', 'success');
            } else {
                FlashMessage::set('student_action', 'Thêm sinh viên thất bại!', 'error');
            }
        }
        // Sau khi thêm, chuyển hướng về trang danh sách
        header('Location: index.php');
        exit();
    }
    // PHƯƠNG THỨC MỚI: Hiển thị form chỉnh sửa (bài 03)
    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            // Nếu không có id, chuyển hướng về trang chủ
            header('Location: index.php');
            exit();
        }
        // Gọi model để lấy thông tin sinh viên
        $student = $this->sinhvienModel->getStudentById($id);
        // Nạp file view để hiển thị form
        require_once __DIR__ . '/../Views/sinhvien_edit.php';
    }
    // PHƯƠNG THỨC MỚI: Xử lý cập nhật dữ liệu (bài 03)
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $course = $_POST['course'] ?? '';
            $class_name = $_POST['class_name'] ?? '';
            $major = $_POST['major'] ?? '';
            $oldAvatar = $_POST['old_avatar'] ?? null;
            $avatar = $oldAvatar;

            // Xử lý upload file mới nếu có
            if (
                isset($_FILES['avatar']) &&
                $_FILES['avatar']['error'] == 0
            ) {
                $uploadResult =
                    $this->handleUpload($_FILES['avatar']);
                if (isset($uploadResult['filename'])) {
                    $avatar = $uploadResult['filename'];
                    // Xóa file ảnh cũ nếu upload thành công ảnh mới
                    if (
                        $oldAvatar && file_exists(PROJECT_ROOT .
                            "/uploads/avatars/" . $oldAvatar)
                    ) {
                        unlink(PROJECT_ROOT .
                            "/uploads/avatars/" . $oldAvatar);
                    }
                } else {
                    FlashMessage::set(
                        'student_action',
                        $uploadResult['error'],
                        'error'
                    );
                    header('Location: index.php');
                    exit();
                }
            }
            if (
                $id && !empty($name) && !empty($email) &&

                !empty($phone)
            ) {

                $this->sinhvienModel->updateStudent(
                    $id,
                    $name,
                    $email,
                    $phone,
                    $course,
                    $class_name,
                    $major,
                    $avatar
                );
                FlashMessage::set('student_action', 'Cập nhật thông tin thành công!', 'success');
            } else {
                FlashMessage::set('student_action', 'Cập nhật thất bại!', 'error');
            }
        }
        // Sau khi cập nhật, chuyển hướng về trang danh sách
        header('Location: index.php');
        exit();
    }
    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            if ($this->sinhvienModel->deleteStudent($id)) {
                FlashMessage::set('student_action', 'Xóa sinh viên thành công!', 'success');

            } else {
                FlashMessage::set('student_action', 'Xóa thất bại!', 'error');
            }
        }
        // Gọi model để thực hiện xóa
        // Sau khi xóa, chuyển hướng người dùng về lại trang danh sách
        header('Location: index.php');
        exit();
    }
    /**
     * Hiển thị trang dashboard thống kê
     */
    public function dashboard()
    {
        // Gọi model để lấy dữ liệu thống kê
        $stats = $this->sinhvienModel->getStatistics();
        // Nạp file view và truyền biến $stats ra
        require_once PROJECT_ROOT . '/src/views/dashboard.php';
    }
    public function detail()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            FlashMessage::set('student_action', 'ID sinh viên không hợp lệ.', 'error');
            header('Location: index.php');
            exit();
        }
        // Tái sử dụng hàm getStudentById đã có
        $student = $this->sinhvienModel->getStudentById($id);
        if (!$student) {
            FlashMessage::set('student_action', 'Không tìm thấy sinh viên.', 'error');
            header('Location: index.php');
            exit();
        }
        // Nạp file view chi tiết và truyền dữ liệu sinh viên
        require_once PROJECT_ROOT . '/src/views/detail.php';
    }
}