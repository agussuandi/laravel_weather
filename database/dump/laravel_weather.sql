/*
 Navicat Premium Data Transfer

 Source Server         : localhostMYSQL
 Source Server Type    : MySQL
 Source Server Version : 100134
 Source Host           : localhost:3306
 Source Schema         : laravel_weather

 Target Server Type    : MySQL
 Target Server Version : 100134
 File Encoding         : 65001

 Date: 24/11/2021 21:14:29
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for m_weather
-- ----------------------------
DROP TABLE IF EXISTS `m_weather`;
CREATE TABLE `m_weather`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `latitude` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `longitude` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `timezone` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `dt` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'string datetime',
  `pressure` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `humidity` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `wind_speed` double(25, 0) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime(0) NOT NULL,
  `updated_by` int(11) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of m_weather
-- ----------------------------
INSERT INTO `m_weather` VALUES (1, '-6.1660572', '106.8296487', 'Asia/Jakarta', '1637726400', '1010', '54', 8, 1, '2021-11-24 13:47:18', NULL, NULL);
INSERT INTO `m_weather` VALUES (2, '-6.1660572', '106.8296487', 'Asia/Jakarta', '1637812800', '1008', '44', 7, 1, '2021-11-24 13:47:18', NULL, NULL);
INSERT INTO `m_weather` VALUES (3, '-6.1660572', '106.8296487', 'Asia/Jakarta', '1637899200', '1009', '54', 4, 1, '2021-11-24 13:47:18', NULL, NULL);
INSERT INTO `m_weather` VALUES (4, '-6.1660572', '106.8296487', 'Asia/Jakarta', '1637985600', '1008', '52', 4, 1, '2021-11-24 13:47:18', NULL, NULL);
INSERT INTO `m_weather` VALUES (5, '-6.1660572', '106.8296487', 'Asia/Jakarta', '1638072000', '1009', '52', 10, 1, '2021-11-24 13:47:18', NULL, NULL);
INSERT INTO `m_weather` VALUES (6, '-6.1660572', '106.8296487', 'Asia/Jakarta', '1638158400', '1008', '59', 6, 1, '2021-11-24 13:47:18', NULL, NULL);
INSERT INTO `m_weather` VALUES (7, '-6.1660572', '106.8296487', 'Asia/Jakarta', '1638244800', '1009', '59', 4, 1, '2021-11-24 13:47:18', NULL, NULL);
INSERT INTO `m_weather` VALUES (8, '-6.1660572', '106.8296487', 'Asia/Jakarta', '1638331200', '1010', '58', 5, 1, '2021-11-24 13:47:18', NULL, NULL);

-- ----------------------------
-- Table structure for m_weather_detail
-- ----------------------------
DROP TABLE IF EXISTS `m_weather_detail`;
CREATE TABLE `m_weather_detail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weather_id` int(11) NOT NULL,
  `weather_api_id` int(11) NOT NULL,
  `main` varchar(75) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `description` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime(0) NOT NULL,
  `updated_by` int(11) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `rel_m_weather`(`weather_id`) USING BTREE,
  CONSTRAINT `rel_m_weather` FOREIGN KEY (`weather_id`) REFERENCES `m_weather` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of m_weather_detail
-- ----------------------------
INSERT INTO `m_weather_detail` VALUES (1, 1, 804, 'Clouds', 'overcast clouds', 1, '2021-11-24 13:47:18', NULL, NULL);
INSERT INTO `m_weather_detail` VALUES (2, 2, 500, 'Rain', 'light rain', 1, '2021-11-24 13:47:18', NULL, NULL);
INSERT INTO `m_weather_detail` VALUES (3, 3, 502, 'Rain', 'heavy intensity rain', 1, '2021-11-24 13:47:18', NULL, NULL);
INSERT INTO `m_weather_detail` VALUES (4, 4, 500, 'Rain', 'light rain', 1, '2021-11-24 13:47:18', NULL, NULL);
INSERT INTO `m_weather_detail` VALUES (5, 5, 801, 'Clouds', 'few clouds', 1, '2021-11-24 13:47:18', NULL, NULL);
INSERT INTO `m_weather_detail` VALUES (6, 6, 500, 'Rain', 'light rain', 1, '2021-11-24 13:47:18', NULL, NULL);
INSERT INTO `m_weather_detail` VALUES (7, 7, 500, 'Rain', 'light rain', 1, '2021-11-24 13:47:18', NULL, NULL);
INSERT INTO `m_weather_detail` VALUES (8, 8, 500, 'Rain', 'light rain', 1, '2021-11-24 13:47:18', NULL, NULL);
INSERT INTO `m_weather_detail` VALUES (9, 8, 801, 'Clouds', 'few clouds', 1, '2021-11-24 21:05:44', NULL, NULL);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `name` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'agus', 'Agus Suandi', '$2a$12$/fX4S52BLD6QWoWSKFL0IuWG5pi3cEejNzEGG7ZmRz7T12IwAmfkm', '2021-11-24 16:42:09', '2021-11-24 16:42:11');

SET FOREIGN_KEY_CHECKS = 1;
