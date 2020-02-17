-- Facility: Example facility
INSERT INTO `facility` (`id`, `name`, `building_name`, `building_no`, `street`, `city`, `county`, `postcode`, `tel_no`) 
  VALUES ('5e4a83211ffd59.63214101', 'Derby Road Group Practice', null, '27-29', 'Derby Rd', 'Portsmouth', 'Hampshire', 'PO2 8HW', '+442392009265');

-- Role: 3 Default roles
INSERT INTO `role` (`description`) VALUES ('administrative_staff');
INSERT INTO `role` (`description`) VALUES ('medical_staff');
INSERT INTO `role` (`description`) VALUES ('patient');

-- Account: Different accounts for each role (password = 'test123')
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('as-5e4685e3c899f1.04316598', 'as-1@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 1, true);
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('as-5e46873222d123.80231466', 'as-2@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 1, true);
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('ms-5e4685f6e57722.33264537', 'ms-1@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 2, true);
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('ms-5e46874b062833.95604018', 'ms-2@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 2, true);
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('pa-5e4686095092e0.76300630', 'pa-1@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 3, true);
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('pa-5e46875705e162.50418870', 'pa-2@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 3, true);
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('pa-5e46876f3d9332.22430483', 'pa-3@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 3, false);
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('pa-5e468774d36a40.10626920', 'pa-4@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 3, false);
