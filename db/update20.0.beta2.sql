ALTER TABLE `zt_risk` add `closedBy` char(30) AFTER `assignedTo`;
ALTER TABLE `zt_risk` add `closedDate` date AFTER `closedBy`;
ALTER TABLE `zt_issue` CHANGE `closeBy` `closedBy` char(30);