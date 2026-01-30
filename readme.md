# Quick Product Editor (WooCommerce)

Plugin chỉnh sửa nhanh sản phẩm WooCommerce bằng AJAX trong trang quản trị,
tối ưu cho website có nhiều sản phẩm (1000+).

---

## 🚀 Tính năng chính

- Chỉnh sửa nhanh trực tiếp trong bảng:
  - Tên sản phẩm
  - Giá / Giá sale
  - Mô tả ngắn
- Hỗ trợ đầy đủ:
  - Simple product
  - Variable product (kèm biến thể)
  - Grouped product
  - External product
- Phân trang AJAX (không reload admin page)
- Tối ưu hiệu năng, không load toàn bộ sản phẩm
- Hỗ trợ đa ngôn ngữ (i18n)

---

## 📂 Cấu trúc plugin

quick-product-editor/
│
├── assets/
│ ├── css/
│ │ └── product.css
│ └── js/
│ └── product.js
│
├── includes/
│ └── core/
│ |     |── class-enqueue.php # Load CSS / JS
│ |     |── class-i18n.php # Load textdomain
│ ├── class-main.php # Load Menu Plugin
│ ├── class-page.php # Render trang admin
│ ├── class-products.php # Load & phân trang sản phẩm (AJAX)
│ └── class-save.php # Lưu sản phẩm (AJAX)
│
├── languages/
│ ├── quick-product-editor.pot
│ ├── quick-product-editor-vi.po
│ └── quick-product-editor-vi.mo
│
├── templates/
│ ├── product-row.php # Render từng dòng sản phẩm
│ └── product-view.php # Giao diện bảng sản phẩm
│
├── quick-product-editor.php # File khởi tạo plugin
├── uninstall.php # Cleanup khi uninstall
├── readme.md


## 🔌 Cách hoạt động (High-level)

- Admin page được render từ `class-page.php`
- Danh sách sản phẩm load qua AJAX (`class-products.php`)
- HTML từng sản phẩm được render bằng `templates/product-row.php`
- Lưu dữ liệu qua AJAX (`class-save.php`)
- JS xử lý phân trang, loading, save nằm trong `assets/js/product.js`

---

## 🌍 Đa ngôn ngữ

Plugin hỗ trợ i18n thông qua thư mục `languages/`  
Textdomain: `quick-product-editor`

---

## 📜 License

GPL v2 or later