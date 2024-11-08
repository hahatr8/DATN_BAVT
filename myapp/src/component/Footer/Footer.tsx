import React from "react";
import "./Footer.scss";

const Footer = () => {
  return (
    <footer className="footer">
      <div className="container">
        {/* Logo và Mô tả */}
        <div className="footer-section">
          <div className="footer-logo">
            <img src="../image/logo.png" alt="Logo" />
          </div>
          <p className="footer-description">
            Chào mừng bạn đến với cửa hàng nước hoa uy tín, chúng tôi cung cấp
            những sản phẩm nước hoa chất lượng với giá cả cạnh tranh nhất.
          </p>
        </div>

        {/* Liên kết nhanh */}
        <div className="footer-section">
          <h4>Liên kết nhanh</h4>
          <ul>
            <li>
              <a href="/perfumes/male">Nước Hoa Nam</a>
            </li>
            <li>
              <a href="/perfumes/female">Nước Hoa Nữ</a>
            </li>
            <li>
              <a href="/perfumes/unisex">Nước Hoa Unisex</a>
            </li>
            <li>
              <a href="/perfumes/sale">Khuyến Mãi</a>
            </li>
            <li>
              <a href="/about">Về Chúng Tôi</a>
            </li>
            <li>
              <a href="/contact">Liên Hệ</a>
            </li>
          </ul>
        </div>

        {/* Thông tin liên hệ */}
        <div className="footer-section">
          <h4>Thông tin liên hệ</h4>
          <ul className="contact-info">
            <li>Địa chỉ: 123 Đường ABC, Quận XYZ, TP HCM</li>
            <li>Email: support@nuochoashop.com</li>
            <li>Điện thoại: +84 123 456 789</li>
            <li>Giờ mở cửa: 9:00 - 21:00 (Thứ 2 - CN)</li>
          </ul>
        </div>

        {/* Mạng xã hội */}
        <div className="footer-section">
          <h4>Kết nối với chúng tôi</h4>
          <div className="social-icons">
            <a href="https://facebook.com" target="_blank" rel="noreferrer">
              <img src="../image/icon/logo-facebook.png" alt="Facebook" />
            </a>
            <a href="https://instagram.com" target="_blank" rel="noreferrer">
              <img src="../image/icon/logo-instagram.png" alt="Instagram" />
            </a>
            <a href="https://zalo.com" target="_blank" rel="noreferrer">
              <img src="../image/icon/logo-zalo.png" alt="Zalo" />
            </a>
          </div>
        </div>
      </div>

      <div className="footer-bottom">
        <p>&copy; 2024 ShopnuochoaSympony. All rights reserved.</p>
      </div>
    </footer>
  );
};

export default Footer;
