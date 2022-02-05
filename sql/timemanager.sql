/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 80025
 Source Host           : localhost:3306
 Source Schema         : timemanager

 Target Server Type    : MySQL
 Target Server Version : 80025
 File Encoding         : 65001

 Date: 05/02/2022 14:15:00
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for pomodoro_item
-- ----------------------------
DROP TABLE IF EXISTS `pomodoro_item`;
CREATE TABLE `pomodoro_item`  (
  `id` int(0) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `item_time` int(0) NULL DEFAULT NULL,
  `rest_time` int(0) NULL DEFAULT 5,
  `display` int(0) NOT NULL DEFAULT 0,
  `create_time` datetime(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 58 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for time_arrange
-- ----------------------------
DROP TABLE IF EXISTS `time_arrange`;
CREATE TABLE `time_arrange`  (
  `id` int(0) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_id` int(0) NOT NULL,
  `item_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `item_time` int(0) NOT NULL,
  `start_time` datetime(0) NOT NULL,
  `finish_time` datetime(0) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
