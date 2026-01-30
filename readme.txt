=== Quick Product Editor ===
Contributors: tai-nguyen
Tags: woocommerce, product editor, quick edit, admin tools
Requires at least: 5.8
Tested up to: 6.4
Requires PHP: 7.2
Stable tag: 1.0.0
License: GPLv2 or later

Sửa nhanh sản phẩm WooCommerce ngay trong trang quản trị với AJAX, hỗ trợ nhiều loại sản phẩm và phân trang.

== Description ==

**Quick Product Editor** là plugin giúp quản trị viên WooCommerce chỉnh sửa sản phẩm nhanh chóng mà không cần mở từng trang chi tiết sản phẩm.

Plugin được xây dựng theo hướng nhẹ, tách logic rõ ràng và sử dụng AJAX để tải dữ liệu theo trang, phù hợp với website có số lượng sản phẩm lớn.

### Tính năng chính

* Sửa nhanh tiêu đề sản phẩm
* Sửa giá và giá khuyến mãi
* Sửa mô tả ngắn (simple product)
* Hỗ trợ các loại sản phẩm:
  * Simple
  * Variable (sửa từng biến thể)
  * Grouped
  * External
* Phân trang bằng AJAX (không load toàn bộ sản phẩm)
* Giao diện bảng quen thuộc trong wp-admin
* Không ảnh hưởng frontend
* Không ghi đè logic WooCommerce gốc

### Kiến trúc

* Admin Page chỉ render HTML (View)
* Load dữ liệu sản phẩm bằng AJAX
* Tách riêng:
  * Page
  * AJAX load
  * AJAX save
  * View (row, table)
  * Assets (CSS / JS)

== Installation ==

1. Upload thư mục `quick-product-editor` vào `/wp-content/plugins/`
2. Kích hoạt plugin trong menu **Plugins**
3. Vào **Sửa nhanh sản phẩm** trong admin menu

== Usage ==

1. Mở menu **Sửa nhanh sản phẩm**
2. Sản phẩm sẽ được tải theo từng trang
3. Chỉnh sửa dữ liệu trực tiếp trong bảng
4. Nhấn **Lưu** để lưu từng dòng

== Screenshots ==

1. Trang danh sách sản phẩm
2. Sửa nhanh biến thể
3. Phân trang AJAX

== Frequently Asked Questions ==

= Plugin có load toàn bộ sản phẩm không? =
Không. Plugin sử dụng phân trang AJAX để chỉ load dữ liệu cần thiết.

= Có ảnh hưởng frontend không? =
Không. Plugin chỉ hoạt động trong wp-admin.

= Có hỗ trợ WooCommerce biến thể không? =
Có. Có thể chỉnh sửa giá và mô tả của từng biến thể.

== Changelog ==

= 1.0.0 =
* Phiên bản đầu tiên
* AJAX load sản phẩm
* Sửa nhanh nhiều loại sản phẩm
* Phân trang admin

== Upgrade Notice ==

= 1.0.0 =
Phiên bản đầu tiên.