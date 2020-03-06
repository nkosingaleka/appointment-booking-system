/* Facility: Example facility */
INSERT INTO `facility` (`id`, `name`, `building_name`, `building_no`, `street`, `city`, `county`, `postcode`, `tel_no`) 
  VALUES ('5e4a83211ffd59.63214101', 'Derby Road Group Practice', null, '27-29', 'Derby Rd', 'Portsmouth', 'Hampshire', 'PO2 8HW', '+442392009265');

/* Role: 3 Default roles */
INSERT INTO `role` (`description`) VALUES ('administrative_staff');
INSERT INTO `role` (`description`) VALUES ('medical_staff');
INSERT INTO `role` (`description`) VALUES ('patient');

/* Account: Different accounts for each role (password = 'test123') */
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('as-5e4685e3c899f1.04316598', 'as1@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 1, true);
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('as-5e46873222d123.80231466', 'as2@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 1, true);
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('ms-5e4685f6e57722.33264537', 'ms1@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 2, true);
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('ms-5e46874b062833.95604018', 'ms2@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 2, true);
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('pa-5e4686095092e0.76300630', 'pa1@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 3, true);
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('pa-5e46875705e162.50418870', 'pa2@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 3, true);
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('pa-5e46876f3d9332.22430483', 'pa3@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 3, false);
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('pa-5e468774d36a40.10626920', 'pa4@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 3, false);

/* Staff: Different accounts for both roles */
INSERT INTO `staff` (`id`, `title`, `forename`, `surname`, `sex`, `job_title`, `facility_id`)
  VALUES ('as-5e4685e3c899f1.04316598', 'Mr', 'Matthew', 'Johnson', 'M', 'Receptionist', '5e4a83211ffd59.63214101');
INSERT INTO `staff` (`id`, `title`, `forename`, `surname`, `sex`, `job_title`, `facility_id`)
  VALUES ('as-5e46873222d123.80231466', 'Mrs', 'Stacey', 'Rhodes', 'F', 'Receptionist', '5e4a83211ffd59.63214101');
INSERT INTO `staff` (`id`, `title`, `forename`, `surname`, `sex`, `job_title`, `facility_id`)
  VALUES ('ms-5e4685f6e57722.33264537', 'Dr', 'Jin', 'Xiao', 'M', 'General Practitioner', '5e4a83211ffd59.63214101');
INSERT INTO `staff` (`id`, `title`, `forename`, `surname`, `sex`, `job_title`, `facility_id`)
  VALUES ('ms-5e46874b062833.95604018', 'Dr', 'Margaret', 'Christchurch', 'F', 'General Practitioner', '5e4a83211ffd59.63214101');

/* Next of Kin: Records for each patient record */
INSERT INTO `next_of_kin` (`id`, `relationship`, `title`, `forename`, `surname`, `house_name`, `house_no`, `street`, `city`, `county`, `postcode`, `tel_no`, `mob_no`)
  VALUES ('nk-5e4693079a5e18.63580261', 'Father', 'Mr', 'Nerti', 'Philson', null, '7', 'London Road', 'Southampton', 'Hampshire', 'SO15 2AE', '+447691014037', '+448865738896');
INSERT INTO `next_of_kin` (`id`, `relationship`, `title`, `forename`, `surname`, `house_name`, `house_no`, `street`, `city`, `county`, `postcode`, `tel_no`, `mob_no`)
  VALUES ('nk-5e4693969040c3.17276446', 'Mother', 'Mrs', 'Consolata', 'Haverson', null, '6532', 'Ocean Way', 'Southampton', 'Hampshire', 'SO14 3JT', '+443147151972', '+441112173010');
INSERT INTO `next_of_kin` (`id`, `relationship`, `title`, `forename`, `surname`, `house_name`, `house_no`, `street`, `city`, `county`, `postcode`, `tel_no`, `mob_no`)
  VALUES ('nk-5e4694c3ad45f4.91981040', 'Daughter', 'Ms', 'Elvera', 'Zotto', null, '71', 'Willis Rd', 'Portsmouth', 'Hampshire', 'PO1 1AT', '+449404753184', '+445158412207');
INSERT INTO `next_of_kin` (`id`, `relationship`, `title`, `forename`, `surname`, `house_name`, `house_no`, `street`, `city`, `county`, `postcode`, `tel_no`, `mob_no`)
  VALUES ('nk-5e4694507dc976.27152557', 'Son', 'Dr', 'Kirby', 'Botler', 'The Willows', null, 'Wilson St', 'Gosport', 'Hampshire', 'PO12 4PQ', '+449685024267', '+448489534531');

/* Patient: Different records for each patient account */
INSERT INTO `patient` (`id`, `title`, `forename`, `surname`, `sex`, `date_of_birth`, `house_name`, `house_no`, `street`, `city`, `county`, `postcode`, `tel_no`, `mob_no`, `next_of_kin`, `NHS_no`, `HC_no`, `contact_by_email`,`contact_by_text`)
  VALUES ('pa-5e4686095092e0.76300630', 'Mr', 'David', 'Bowden', 'M', '1990-01-26', null, '12', 'Meyrick Road', 'Portsmouth', 'Hampshire', 'PO2 RJF', '+447691014037', '+448865738896', 'nk-5e4693079a5e18.63580261', '4562594365', null, null, null);
INSERT INTO `patient` (`id`, `title`, `forename`, `surname`, `sex`, `date_of_birth`, `house_name`, `house_no`, `street`, `city`, `county`, `postcode`, `tel_no`, `mob_no`, `next_of_kin`, `NHS_no`, `HC_no`, `contact_by_email`,`contact_by_text`)
  VALUES ('pa-5e46875705e162.50418870', 'Mrs', 'Jeanette', 'Cowles', 'F', '1940-02-12', null, '14', 'Meyrick Road', 'Portsmouth', 'Hampshire', 'PO2 RJF', '+445611214623', '+449869745821', 'nk-5e4693969040c3.17276446', '8074819035', null, null, null);
INSERT INTO `patient` (`id`, `title`, `forename`, `surname`, `sex`, `date_of_birth`, `house_name`, `house_no`, `street`, `city`, `county`, `postcode`, `tel_no`, `mob_no`, `next_of_kin`, `NHS_no`, `HC_no`, `contact_by_email`,`contact_by_text`)
  VALUES ('pa-5e46876f3d9332.22430483', 'Mr', 'Bob', 'Zotto', 'M', '1960-08-18', null, '5888', 'Park Drive', 'Gosport', 'Hampshire', 'PO12 6DR', '+446893649145', '+445171936505', 'nk-5e4694c3ad45f4.91981040', '8586218634', null, null, null);
INSERT INTO `patient` (`id`, `title`, `forename`, `surname`, `sex`, `date_of_birth`, `house_name`, `house_no`, `street`, `city`, `county`, `postcode`, `tel_no`, `mob_no`, `next_of_kin`, `NHS_no`, `HC_no`, `contact_by_email`,`contact_by_text`)
  VALUES ('pa-5e468774d36a40.10626920', 'Ms', 'Shirley', 'Banks', 'F', '1978-12-05', null, '705', 'Cross St', 'Winchester', 'Hampshire', 'SO20 6Pj', '+447102306288', '+445841903874', 'nk-5e4694507dc976.27152557', '4456772352', null, null, null);

/* Slot: Time slots for which patients may make appointment booking requests (Mon, Tue, Wed, Thu, Fri, Sat, and Sun of current week) */
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700174.12262196', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 09:00:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 09:10:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47001c1.91031235', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 09:10:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 09:20:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47001d1.96456823', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 09:20:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 09:30:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47001e5.95247456', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 09:30:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 09:40:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47001f5.32309261', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 09:40:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 09:50:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700201.70329146', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 09:50:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 10:00:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700213.94939221', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 10:00:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 10:10:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700223.11459087', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 10:10:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 10:20:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700230.47065592', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 10:20:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 10:30:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700245.09717618', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 10:30:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 10:40:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700252.60187231', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 10:40:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 10:50:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700267.77683201', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 10:50:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE())), ' 11:00:00')));

INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700270.30601035', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 09:00:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 09:10:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700280.55658484', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 09:10:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 09:20:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700290.42187533', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 09:20:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 09:30:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47002a5.09197727', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 09:30:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 09:40:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47002b3.52547517', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 09:40:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 09:50:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47002c4.65175032', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 09:50:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 10:00:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47002d6.95115050', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 10:00:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 10:10:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47002e4.68573828', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 10:10:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 10:20:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47002f7.30764070', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 10:20:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 10:30:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700308.19636337', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 10:30:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 10:40:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700314.49969519', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 10:40:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 10:50:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700322.42011059', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 10:50:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 1), ' 11:00:00')));

INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700330.92202765', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 09:00:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 09:10:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700343.15345331', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 09:10:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 09:20:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700355.36260025', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 09:20:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 09:30:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700368.97567150', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 09:30:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 09:40:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700374.36143190', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 09:40:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 09:50:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700381.03135929', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 09:50:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 10:00:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700394.67012892', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 10:00:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 10:10:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47003a9.20211607', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 10:10:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 10:20:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47003b6.59226417', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 10:20:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 10:30:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47003c2.43798754', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 10:30:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 10:40:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47003d6.61386784', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 10:40:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 10:50:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47003e3.33449814', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 10:50:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 2), ' 11:00:00')));

INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47003f1.85041802', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 09:00:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 09:10:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700403.34165086', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 09:10:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 09:20:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700417.69916221', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 09:20:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 09:30:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700426.30417125', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 09:30:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 09:40:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700430.96610488', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 09:40:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 09:50:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700446.44916200', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 09:50:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 10:00:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700459.06846302', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 10:00:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 10:10:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700462.39672744', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 10:10:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 10:20:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700475.76716563', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 10:20:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 10:30:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700487.71335715', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 10:30:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 10:40:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700496.79719224', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 10:40:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 10:50:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47004a6.55914235', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 10:50:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 3), ' 11:00:00')));

INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47004b7.86034960', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 09:00:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 09:10:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47004c3.42095722', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 09:10:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 09:20:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47004d6.86952692', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 09:20:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 09:30:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47004e8.17831044', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 09:30:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 09:40:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47004f8.36142053', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 09:40:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 09:50:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700507.80572271', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 09:50:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 10:00:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700514.73018141', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 10:00:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 10:10:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700528.79898461', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 10:10:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 10:20:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700535.15002941', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 10:20:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 10:30:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700547.97117112', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 10:30:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 10:40:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700556.51023669', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 10:40:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 10:50:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700568.40103706', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 10:50:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 4), ' 11:00:00')));

INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700572.01748242', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 09:00:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 09:10:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700583.37604776', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 09:10:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 09:20:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700592.80393715', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 09:20:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 09:30:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47005a7.58822409', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 09:30:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 09:40:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47005b4.39278555', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 09:40:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 09:50:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47005c3.44444612', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 09:50:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 10:00:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47005d5.19083799', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 10:00:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 10:10:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47005e9.79969646', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 10:10:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 10:20:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47005f7.04600528', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 10:20:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 10:30:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700603.19468974', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 10:30:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 10:40:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700613.99979173', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 10:40:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 10:50:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700621.76116134', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 10:50:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 5), ' 11:00:00')));

INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700634.70531922', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 09:00:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 09:10:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700641.76627722', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 09:10:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 09:20:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700655.33443223', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 09:20:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 09:30:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700668.11306931', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 09:30:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 09:40:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700670.79867069', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 09:40:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 09:50:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700685.48043933', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 09:50:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 10:00:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd4700698.93454644', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 10:00:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 10:10:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47006a9.49433144', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 10:10:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 10:20:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47006b6.95461734', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 10:20:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 10:30:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47006c2.15319743', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 10:30:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 10:40:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47006d7.82257086', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 10:40:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 10:50:00')));
INSERT INTO `slot` (`id`, `start_time`, `end_time`) 
  VALUES ('5e5f9bd47006e4.04775992', TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 10:50:00')), TIMESTAMP(CONCAT(SUBDATE(CURDATE(), WEEKDAY(CURDATE()) - 6), ' 11:00:00')));

/* Language: Example languages for selecting translation services */
INSERT INTO `language` (`id`, `name`) VALUES ('5e6274fe2da8e7.62206293', 'Welsh');
INSERT INTO `language` (`id`, `name`) VALUES ('5e627504477ac0.53112804', 'Polish');
INSERT INTO `language` (`id`, `name`) VALUES ('5e62752a775762.64611390', 'Bengali');
INSERT INTO `language` (`id`, `name`) VALUES ('5e62752a775924.80449764', 'Gujarati');
INSERT INTO `language` (`id`, `name`) VALUES ('5e62752a775a30.18919537', 'Arabic');
INSERT INTO `language` (`id`, `name`) VALUES ('5e62752a775a78.73040756', 'Urdu');
INSERT INTO `language` (`id`, `name`) VALUES ('5e62752a775aa8.85707788', 'French');
INSERT INTO `language` (`id`, `name`) VALUES ('5e62752a775ae7.54844103', 'Romanian');

/* Facility_Language: Example languages offered by facilities */
INSERT INTO `facility_language` (`id`, `facility_id`, `language_id`) 
  VALUES ('5e627634038156.50370377', '5e4a83211ffd59.63214101', '5e6274fe2da8e7.62206293');
INSERT INTO `facility_language` (`id`, `facility_id`, `language_id`) 
  VALUES ('5e627634038285.25464470', '5e4a83211ffd59.63214101', '5e627504477ac0.53112804');
INSERT INTO `facility_language` (`id`, `facility_id`, `language_id`) 
  VALUES ('5e6276340382d6.44937900', '5e4a83211ffd59.63214101', '5e62752a775762.64611390');
INSERT INTO `facility_language` (`id`, `facility_id`, `language_id`) 
  VALUES ('5e627634038309.12561632', '5e4a83211ffd59.63214101', '5e62752a775a30.18919537');
INSERT INTO `facility_language` (`id`, `facility_id`, `language_id`) 
  VALUES ('5e627634038339.11156979', '5e4a83211ffd59.63214101', '5e62752a775aa8.85707788');
INSERT INTO `facility_language` (`id`, `facility_id`, `language_id`) 
  VALUES ('5e627634038370.51360289', '5e4a83211ffd59.63214101', '5e62752a775ae7.54844103');
