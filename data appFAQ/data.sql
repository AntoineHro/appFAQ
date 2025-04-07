-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `pseudo`, `mdp`, `mail`, `id_usertype`, `id_ligue`) 
VALUES
(12, 'SuperAdmin', '$2y$10$QiAP4jaNpBtZ6WgU9YihPO.O.gFJdPIFv9twkex6/HPjSQgocYele', 'superadmin@limayrac.fr', 3, 5),
(14, 'adminfoot', '$2y$10$hwVoAW2fXYizEn6OvKrBh.KvHG.0ICp.LYbw2vTJdR.r8c1J2JyoS', 'adminfoot@limayrac.com', 2, 1),
(15, 'adminvolley', '$2y$10$dwlu7QT2GVy1n9WO/iScOOMsI.RT7OLsYDllnHBhcVhRvK.F7mJnu', 'adminvolley@limayrac.fr', 2, 3),
(16, 'adminhand', '$2y$10$EzPoMByyznAq55EYVZXeYuLkq7law3UFRW7.wFFpb/xNomxJZJtEK', 'adminhand@limayrac.fr', 2, 4),
(17, 'adminbasket', '$2y$10$aj9DpH/idqx1QkQsbto4UeO/oVRN49cliqTWM1YKsis7IvS0zuWXa', 'adminbasket@limayrac.fr', 2, 2),
(23, 'U1foot', '$2y$10$s6H/lQV4kolUMGj9NW28OO4m8BH1lJEOLhCi9AEMj5YbO1d.uN3XW', 'utilisateurfoot@limayrac.fr', 1, 1),
(25, 'U1basketball', '$2y$10$PUakTEfx2lXPovUyzra4dusAWe6DwVSbD0RdM1zIWbG62HgeaY3Ku', 'utilisateurbasketball@limayrac.Fr', 1, 2),
(26, 'U1volleyball', '$2y$10$..3oVTF4L4ed4dCf/ly.3OFl0iOKnnF.SYfslXk8oGiWzdQagbmWy', 'utilisateurvolleyball@limayrac.fr', 1, 3),
(27, 'U1handball', '$2y$10$FJRjJcIXRY3HoCQcLIrg/OboH/9FG7Ms3YbjQV1Ng337v7rG7MGlq', 'utilisateurhandball@limayrac.fr', 1, 4);
