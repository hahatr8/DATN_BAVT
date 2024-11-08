import React, { useEffect, useState } from "react";
import { useParams, Link } from "react-router-dom";
import axiosInstance from "../../axios/api";
import { Product } from "../../interface/types";
import "./ProductDetail.scss";

const ProductDetail = () => {
  const { id } = useParams<{ id: string }>();
  const [product, setProduct] = useState<Product | null>(null);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const fetchProductDetail = async () => {
      try {
        const response = await axiosInstance.get<Product>(`/products/${id}`);
        setProduct(response.data);
        console.log(response.data);
      } catch (error) {
        console.error("Error fetching product details:", error);
        setError("Failed to fetch product details.");
      }
    };

    fetchProductDetail();
  }, [id]);

  if (error) {
    return <div>{error}</div>;
  }

  if (!product) {
    return <p>Loading product details...</p>;
  }

  return (
    <div className="product-detail-container">
      <Link to="/products">Back to Product List</Link>
      <h1>{product.name}</h1>
      <img src={product.image} alt={product.name} className="product-image" />
      <p>{product.description}</p>
      <p>
        {product.price.toLocaleString("vi-VN", {
          style: "currency",
          currency: "VND",
        })}
      </p>
      <button>Thêm vào giỏ hàng</button>
    </div>
  );
};

export default ProductDetail;
