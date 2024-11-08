import axios from "axios";

const axiosInstance = axios.create({
  baseURL: "http://localhost:3000", // Đảm bảo URL này đúng với nơi bạn chạy JSON Server
  headers: {
    "Content-Type": "application/json"
  }
});

export default axiosInstance;
