--
-- Database: `cineflix`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `subscription` varchar(50) NOT NULL DEFAULT 'None',
  `role` enum('user','admin','super_admin') NOT NULL DEFAULT 'user',
  `profile_pic_url` varchar(255) DEFAULT 'https://i.pravatar.cc/150',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--
INSERT INTO `users` (`id`, `username`, `email`, `password`, `subscription`, `role`) VALUES
(1, 'admin', 'admin@cineflix.com', '$2y$10$EKKg28NCt35D2xI74tq/N.kG9E.VLz2T6sPTtEwT7G/G0x4A6fCUC', 'Diamond+', 'super_admin'),
(2, 'testuser', 'test@example.com', '$2y$10$wAXJ5hH2P5E7fR.y8U.jZOJmX2fKbY3K6Z/1yQG.zG.8uY8wL9C.e', 'None', 'user'),
(3, 'subscriber', 'sub@example.com', '$2y$10$9G9r8o7sP.fA3bE4C5D6E7fG8hI9jK0lM1nO2pQ3rS4tU5vW6xY7', 'Diamond', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--
DROP TABLE IF EXISTS `media`;
CREATE TABLE `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `rating` decimal(3,1) NOT NULL,
  `poster` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `exclusive` tinyint(1) NOT NULL DEFAULT 0,
  `type` varchar(50) NOT NULL DEFAULT 'movie',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `media`
--
INSERT INTO `media` (`id`, `title`, `year`, `rating`, `poster`, `description`, `exclusive`, `type`) VALUES
(1, 'Inception', 2010, '8.8', 'https://image.tmdb.org/t/p/w500/oYuLEt3zVCKq27gApcjBJUuNXwg.jpg', 'A thief who steals corporate secrets through dream-sharing technology.', 1, 'movie'),
(2, 'The Dark Knight', 2008, '9.0', 'https://image.tmdb.org/t/p/w500/qJ2tW6WMUDux911r6m7haRef0WH.jpg', 'The Joker wreaks havoc on Gotham, forcing Batman to confront one of his greatest tests.', 0, 'movie'),
(3, 'Interstellar', 2014, '8.6', 'https://image.tmdb.org/t/p/w500/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg', 'Explorers travel through a wormhole to ensure humanity\'s survival.', 1, 'movie'),
(4, 'Parasite', 2019, '8.5', 'https://image.tmdb.org/t/p/w500/7IiTTgloJzvGI1TAYymCfbfl3vT.jpg', 'Greed and class discrimination threaten the symbiotic relationship between two families.', 0, 'movie'),
(5, 'Stranger Things', 2016, '8.7', 'https://image.tmdb.org/t/p/w500/49WJfeN0moxb9IPfGn8AIqMGskD.jpg', 'A young boy\'s disappearance uncovers a mystery involving secret experiments and a strange little girl.', 1, 'web-series'),
(11, 'Breaking Bad', 2008, '9.5', 'https://image.tmdb.org/t/p/w500/ggFHVNu6YYI5L9pCfOacjizRGt.jpg', 'A high school chemistry teacher diagnosed with inoperable lung cancer turns to manufacturing and selling methamphetamine.', 1, 'web-series'),
(13, 'The Shawshank Redemption', 1994, '9.3', 'https://image.tmdb.org/t/p/w500/q6y0Go1tsGEsmtFryDOJo3dEmq.jpg', 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.', 0, 'movie'),
(14, 'The Godfather', 1972, '9.2', 'https://image.tmdb.org/t/p/w500/3bhkrj58Vtu7enYsRolD1fZdja1.jpg', 'The aging patriarch of an an organized crime dynasty transfers control of his clandestine empire to his reluctant son.', 1, 'movie');
(15, 'Joker', 2019, '8.4', 'https://image.tmdb.org/t/p/w500/udDclJoHjfjb8Ekgsd4FDteOkCU.jpg', 'A failed comedian descends into madness.', 1, 'movie'),
(16, 'Money Heist', 2017, '8.3', 'https://image.tmdb.org/t/p/w500/reEMJA1uzscCbkpeRJeTT2bjqUp.jpg', 'A mastermind leads a heist on Spain''s Mint.', 1, 'webseries'),
(17, 'The Mandalorian', 2019, '8.7', 'https://image.tmdb.org/t/p/w500/sWgBv7LV2PRoQgkxwlibdGXKz1S.jpg', 'A lone gunfighter in the outer reaches of the galaxy.', 1, 'webseries'),
(18, 'Parasite', 2019, '8.5', 'https://image.tmdb.org/t/p/w500/7IiTTgloJzvGI1TAYymCfbfl3vT.jpg', 'A poor family infiltrates a wealthy household.', 1, 'movie'),
(19, 'Peaky Blinders', 2013, '8.8', 'https://image.tmdb.org/t/p/w500/bGZn5RVzMMXju4ev7xbl1aLdXqq.jpg', 'A gangster family in 1900s England.', 1, 'webseries'),
(20, 'Inception', 2010, '8.8', 'https://image.tmdb.org/t/p/w500/edv5CZvWj09upOsy2Y6IwDhK8bt.jpg', 'A thief enters dreams to steal secrets but must pull off one last impossible job.', 1, 'movie'),
(21, 'Fight Club', 1999, '8.8', 'https://image.tmdb.org/t/p/w500/bptfVGEQuv6vDTIMVCHjJ9Dz8PX.jpg', 'An insomniac office worker and a soapmaker form an underground fight club.', 0, 'movie'),
(22, 'Pulp Fiction', 1994, '8.9', 'https://image.tmdb.org/t/p/w500/dM2w364MScsjFf8pfMbaWUcWrR.jpg', 'The lives of two hitmen, a boxer, and others intertwine in violent tales.', 1, 'movie'),
(23, 'Forrest Gump', 1994, '8.8', 'https://image.tmdb.org/t/p/w500/saHP97rTPS5eLmrLQEcANmKrsFl.jpg', 'The story of Forrest Gump, a man with a low IQ who influences key moments in history.', 0, 'movie'),
(24, 'The Matrix', 1999, '8.7', 'https://image.tmdb.org/t/p/w500/f89U3ADr1oiB1s9GkdPOEpXUk5H.jpg', 'A hacker learns the shocking truth about his reality and his role in the war against its controllers.', 1, 'movie'),
(25, 'Interstellar', 2014, '8.6', 'https://image.tmdb.org/t/p/w500/rAiYTfKGqDCRIIqo664sY9XZIvQ.jpg', 'A group of explorers travel through a wormhole in search of a new home for humanity.', 0, 'movie'),
(26, 'Parasite', 2019, '8.5', 'https://image.tmdb.org/t/p/w500/7IiTTgloJzvGI1TAYymCfbfl3vT.jpg', 'A poor family infiltrates a wealthy household with unexpected consequences.', 1, 'movie'),
(27, 'Avengers: Endgame', 2019, '8.4', 'https://image.tmdb.org/t/p/w500/or06FN3Dka5tukK1e9sl16pB3iy.jpg', 'The Avengers assemble for a final showdown against Thanos.', 1, 'movie'),
(28, 'Breaking Bad', 2008, '9.5', 'https://image.tmdb.org/t/p/w500/ggFHVNu6YYI5L9pCfOacjizRGt.jpg', 'A chemistry teacher diagnosed with cancer begins manufacturing meth.', 1, 'webseries'),
(29, 'Stranger Things', 2016, '8.7', 'https://image.tmdb.org/t/p/w500/x2LSRK2Cm7MZhjluni1msVJ3wDF.jpg', 'A group of kids uncover supernatural mysteries in a small town.', 0, 'webseries'),
(30, 'Game of Thrones', 2011, '9.3', 'https://image.tmdb.org/t/p/w500/u3bZgnGQ9T01sWNhyveQz0wH0Hl.jpg', 'Noble families vie for control of the Iron Throne of Westeros.', 1, 'webseries'),
(31, 'The Witcher', 2019, '8.2', 'https://image.tmdb.org/t/p/w500/7vjaCdMw15FEbXyLQTVa04URsPm.jpg', 'A monster hunter struggles to find his place in a world where people can be worse than beasts.', 0, 'webseries'),
(32, 'Money Heist', 2017, '8.3', 'https://image.tmdb.org/t/p/w500/reEMJA1uzscCbkpeRJeTT2bjqUp.jpg', 'A criminal mastermind and his team plan the biggest heist in history.', 1, 'webseries'),
(33, 'Chernobyl', 2019, '9.4', 'https://image.tmdb.org/t/p/w500/hlLXt2tOPT6RRnjiUmoxyG1LTFi.jpg', 'The true story of one of the worst man-made disasters in history.', 0, 'webseries'),
(34, 'The Boys', 2019, '8.7', 'https://image.tmdb.org/t/p/w500/mY7SeH4HFFxW1hiI6cWuwCRKptN.jpg', 'A group of vigilantes take on corrupt superheroes.', 1, 'webseries'),
(35, 'Peaky Blinders', 2013, '8.8', 'https://image.tmdb.org/t/p/w500/bGZn5RVzMMXju4ev7xbl1aLdXqq.jpg', 'A gangster family epic set in 1900s England.', 0, 'webseries');
(36, 'Lucifer', 2016, '8.1', 'https://image.tmdb.org/t/p/w500/ekZobS8isE6mA53RAiGDG93hBxL.jpg', 'The Devil abandons Hell and runs a nightclub in Los Angeles while helping the LAPD.', 1, 'webseries'),
(37, 'Narcos', 2015, '8.8', 'https://image.tmdb.org/t/p/w500/rTmal9fDbwh5F0waol2hq35U4ah.jpg', 'The true-life stories of Colombia’s drug lords and the DEA agents fighting them.', 0, 'webseries'),
(38, 'Frozen', 2013, '7.5', 'https://image.tmdb.org/t/p/w500/kgwjIb2JDHRhNk13lw6uUbrhDdM.jpg', 'Two sisters fight to save their kingdom from eternal winter.', 1, 'movie'),
(39, 'Iron Man', 2008, '7.9', 'https://image.tmdb.org/t/p/w500/78lPtwv72eTNqFW9COBYI0dWDJa.jpg', 'Tony Stark builds a high-tech suit of armor to save his life and fight evil.', 1, 'movie'),
(40, 'Vikings', 2013, '8.5', 'https://image.tmdb.org/t/p/w500/aq2yM8KyxB7b3h4gTHoAu8jT5r6.jpg', 'The legendary saga of Ragnar Lothbrok and his Viking warriors.', 0, 'webseries');
(41, 'Lost', 2004, '8.3', 'https://image.tmdb.org/t/p/w500/ogM2hzWNoJg9RTxwIdUuVo1yECL.jpg', 'Survivors of a plane crash face mysteries on an island.', 0, 'webseries'),
(42, 'Avatar', 2009, '7.9', 'https://image.tmdb.org/t/p/w500/jRXYjXNq0Cs2TcJjLkki24MLp7u.jpg', 'A paraplegic marine on an alien planet joins its people.', 1, 'movie'),
(43, 'The Office', 2005, '9.0', 'https://image.tmdb.org/t/p/w500/qWnJzyZhyy74gjpSjIXWmuk0ifX.jpg', 'A mockumentary on office workers in Scranton.', 0, 'webseries'),
(44, 'Friends', 1994, '8.9', 'https://image.tmdb.org/t/p/w500/f496cm9enuEsZkSPzCwnTESEK5s.jpg', 'Six friends navigate life and love in New York City.', 0, 'webseries'),
(45, 'Severance', 2022, '8.6', 'https://image.tmdb.org/t/p/w500/ugvV5Z5SzzQ3CFAmDvj8BqCkN44.jpg', 'Employees undergo a procedure that separates work and personal memories.', 1, 'webseries'),
(46, 'The Simpsons', 1989, '8.7', 'https://image.tmdb.org/t/p/w500/zI3E2a3WYma5w8emI35mgq5Iurx.jpg', 'Animated comedy about a dysfunctional family.', 0, 'webseries'),
(47, 'The Avengers', 2012, '8.0', 'https://image.tmdb.org/t/p/w500/RYMX2wcKCBAr24UyPD7xwmjaTn.jpg', 'Earth’s mightiest heroes assemble to fight Loki.', 1, 'movie'),
(48, 'The Big Bang Theory', 2007, '8.1', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'A group of nerdy friends navigate life and science.', 0, 'webseries'),
(49, 'Squid Game', 2021, '8.2', 'https://image.tmdb.org/t/p/w500/dDlEmu3EZ0Pgg93K2SVNLCjCSvE.jpg', 'Hundreds compete in deadly games for money.', 1, 'webseries'),
(50, 'Titanic', 1997, '7.9', 'https://image.tmdb.org/t/p/w500/9xjZS2rlVxm8SFx8kPC3aIGCOYQ.jpg', 'A romance blossoms on the ill-fated Titanic.', 0, 'movie'),
(51, 'The Flash', 2014, '7.6', 'https://image.tmdb.org/t/p/w500/lJA2RCMfsWoskqlQhXPSLFQGXEJ.jpg', 'Barry Allen becomes the fastest man alive.', 0, 'webseries'),
(52, 'Loki', 2021, '8.2', 'https://image.tmdb.org/t/p/w500/kEl2t3OhXc3Zb9FBh1AuYzRTgZp.jpg', 'The God of Mischief steps out of his brother’s shadow.', 1, 'webseries'),
(53, 'Doctor Strange', 2016, '7.5', 'https://image.tmdb.org/t/p/w500/gwi5kYyqS7ZlDoN0fTguSuWj5DC.jpg', 'A surgeon discovers mystic arts after an accident.', 1, 'movie'),
(54, 'The Social Network', 2010, '7.8', 'https://image.tmdb.org/t/p/w500/n0ybibhJtQ5icDqTp8eRytcIHJx.jpg', 'The story of the founding of Facebook.', 0, 'movie');
(55, 'Sanam Teri Kasam', 2016, '7.5', 'https://image.tmdb.org/t/p/w500/v3pbMbeqPfq7uR3vY9VOGQsv5nR.jpg', 'A tragic love story between a misunderstood boy and a girl longing for acceptance.', 0, 'movie');
(56, '3 Idiots', 2009, '8.4', 'https://image.tmdb.org/t/p/w500/66i9Mk2t1Ik5dUvNbKQ5E5rXPvs.jpg', 'Three friends challenge the education system in India.', 1, 'movie'),
(57, 'Dangal', 2016, '8.4', 'https://image.tmdb.org/t/p/w500/xq5J4Pw8yg1OQ9UfzWkP2YBz4sQ.jpg', 'A father trains his daughters to become world-class wrestlers.', 1, 'movie'),
(58, 'Gully Boy', 2019, '8.0', 'https://image.tmdb.org/t/p/w500/8j58iEBw9pOXFD2L0nt0ZXeHviB.jpg', 'A street rapper rises from Mumbai slums.', 0, 'movie'),
(59, 'Lagaan', 2001, '8.1', 'https://image.tmdb.org/t/p/w500/8l5l7Z4SO6L58LdzbuzpAo7P5PL.jpg', 'Villagers challenge British rulers to a game of cricket.', 1, 'movie'),
(60, 'PK', 2014, '8.1', 'https://image.tmdb.org/t/p/w500/kBf3g9crrADGMc2AMAMlLBgSm2h.jpg', 'An alien questions blind faith in India.', 0, 'movie'),
(61, 'Zindagi Na Milegi Dobara', 2011, '8.2', 'https://image.tmdb.org/t/p/w500/l2tQ0jz5iI4vGUtkWxppIqhzyzk.jpg', 'Three friends go on a road trip of self-discovery.', 1, 'movie'),
(62, 'Kabir Singh', 2019, '7.0', 'https://image.tmdb.org/t/p/w500/5aGhaIHYuQbqlHWvWYqMCnj40y2.jpg', 'A brilliant but self-destructive surgeon spirals after heartbreak.', 0, 'movie'),
(63, 'Shershaah', 2021, '8.4', 'https://image.tmdb.org/t/p/w500/6cx2prDq7QWqFrrcq6Y3rO1eE8O.jpg', 'Biopic of Captain Vikram Batra, a Kargil war hero.', 1, 'movie'),
(64, 'Article 15', 2019, '8.2', 'https://image.tmdb.org/t/p/w500/9JGHJsbgx5caGV5WDHnhbIVdQyE.jpg', 'An IPS officer investigates caste-based discrimination.', 1, 'movie'),
(65, 'Andhadhun', 2018, '8.3', 'https://image.tmdb.org/t/p/w500/oYrKfdH37EqMaRMuMJnqd7qV3Cy.jpg', 'A blind pianist is caught in a murder mystery.', 0, 'movie'),
(66, 'Barfi!', 2012, '8.1', 'https://image.tmdb.org/t/p/w500/sQSMVXni1VlzDqgW8sELpAoCYXM.jpg', 'A mute and deaf man''s love story full of innocence.', 1, 'movie'),
(67, 'Chakde! India', 2007, '8.2', 'https://image.tmdb.org/t/p/w500/8CXvQydb9h9NP7VDaRao7IhiHBp.jpg', 'A disgraced hockey player coaches the Indian women’s team.', 0, 'movie'),
(68, 'Taare Zameen Par', 2007, '8.4', 'https://image.tmdb.org/t/p/w500/sHJEuwZy4v5n7Zt9JcYy1o6xp6o.jpg', 'A teacher helps a dyslexic child discover his true potential.', 1, 'movie'),
(69, 'Queen', 2013, '8.1', 'https://image.tmdb.org/t/p/w500/bmX7hwgoonZMCGgxORs5KqsNRbR.jpg', 'A young woman embarks on a solo honeymoon trip to Europe.', 0, 'movie'),
(70, 'Dil Chahta Hai', 2001, '8.1', 'https://image.tmdb.org/t/p/w500/jvyWSrFubXDU7wgnWbrZwrHgMHx.jpg', 'Three inseparable childhood friends face adulthood changes.', 1, 'movie'),
(71, 'Kal Ho Naa Ho', 2003, '8.0', 'https://image.tmdb.org/t/p/w500/vzS6O8tZTna8fDcSu7tYvK0Y3R0.jpg', 'A dying man teaches a woman to embrace life and love.', 0, 'movie'),
(72, 'My Name Is Khan', 2010, '8.0', 'https://image.tmdb.org/t/p/w500/u8sW0H0TADaBrZEcD3xKhsR4H2v.jpg', 'A man with Asperger’s embarks on a journey to meet the U.S. President.', 1, 'movie'),
(73, 'Bhaag Milkha Bhaag', 2013, '8.2', 'https://image.tmdb.org/t/p/w500/rdyz8xmPKzW0fvkYhpQ2cEeoBHw.jpg', 'The story of athlete Milkha Singh’s struggles and triumphs.', 1, 'movie'),
(74, 'Rockstar', 2011, '7.7', 'https://image.tmdb.org/t/p/w500/pG0rzG32IOzBSSMSmc5QwDFi1C5.jpg', 'A musician’s passion and heartbreak shape his journey.', 0, 'movie'),
(75, 'Padmaavat', 2018, '7.0', 'https://image.tmdb.org/t/p/w500/7sOIuVkkpFmS6r30YIOCQM7DDDe.jpg', 'The story of Queen Padmavati and Alauddin Khilji.', 1, 'movie'),
(76, 'Jab We Met', 2007, '7.9', 'https://image.tmdb.org/t/p/w500/fvY0RduCMsZqiXXdK5vC41HKvZN.jpg', 'A depressed businessman meets a free-spirited girl on a train journey.', 0, 'movie'),
(77, 'Drishyam', 2015, '8.2', 'https://image.tmdb.org/t/p/w500/zTz9F8j2dZbW9nMXzXgZAjtZ4Vn.jpg', 'A man uses his wit to save his family after a crime.', 1, 'movie'),
(78, 'Pink', 2016, '8.1', 'https://image.tmdb.org/t/p/w500/8N2VNivX5hJ9V7H5P4xM4gJmU16.jpg', 'A courtroom drama that questions societal judgment of women.', 0, 'movie'),
(79, 'Super 30', 2019, '7.9', 'https://image.tmdb.org/t/p/w500/6n6yMfdbPEZ7x1YgnSUZXoqBYw7.jpg', 'A teacher trains underprivileged students for IIT exams.', 1, 'movie'),
(80, 'Stree', 2018, '7.5', 'https://image.tmdb.org/t/p/w500/g7c8y3r4gJwg7p3NzcEBjXJfLQ2.jpg', 'A small town is haunted by a mysterious female spirit.', 0, 'movie'),
(81, 'Sacred Games', 2018, '8.6', 'https://image.tmdb.org/t/p/w500/2w6VYLRh1SeIKMqz4tWl6Q0x3dJ.jpg', 'A cop uncovers a crime lord’s deadly conspiracy in Mumbai.', 1, 'webseries'),
(82, 'Delhi Crime', 2019, '8.5', 'https://image.tmdb.org/t/p/w500/wiu9HcFn3AdVwGv61U4bku2AzL5.jpg', 'Based on the 2012 Delhi gang rape case investigation.', 1, 'webseries'),
(83, 'Made in Heaven', 2019, '8.3', 'https://image.tmdb.org/t/p/w500/eqzA94ppWKqhzyapMI2vlA38nS9.jpg', 'Wedding planners navigate traditions and modern conflicts.', 0, 'webseries'),
(84, 'Mirzapur', 2018, '8.5', 'https://image.tmdb.org/t/p/w500/50Lr7Y2vDLteA94ppLvhJN9Wew5.jpg', 'Power struggles and crime in a small town in Uttar Pradesh.', 1, 'webseries'),
(85, 'Paatal Lok', 2020, '8.0', 'https://image.tmdb.org/t/p/w500/8aVwN0h3hFCXohM3ULICwhf66A3.jpg', 'A cop investigates a case leading to dark secrets of society.', 0, 'webseries');
(86, 'The Big Bang Theory - Season 2', 2008, '8.2', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'Leonard pursues Penny while Sheldon’s quirks shine brighter.', 0, 'webseries'),
(87, 'The Big Bang Theory - Season 3', 2009, '8.3', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'Penny and Leonard’s relationship deepens as Sheldon finds new challenges.', 0, 'webseries'),
(88, 'The Big Bang Theory - Season 4', 2010, '8.1', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'New characters like Amy and Bernadette join, changing group dynamics.', 1, 'webseries'),
(89, 'The Big Bang Theory - Season 5', 2011, '8.2', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'Romantic relationships evolve with Sheldon and Amy, Leonard and Penny.', 0, 'webseries'),
(90, 'The Big Bang Theory - Season 6', 2012, '8.1', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'Howard goes to space and relationships continue to grow.', 0, 'webseries'),
(91, 'The Big Bang Theory - Season 7', 2013, '8.3', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'Sheldon faces personal growth challenges as Penny commits to acting.', 1, 'webseries'),
(92, 'The Big Bang Theory - Season 8', 2014, '8.1', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'Sheldon’s trip changes his perspective, Penny and Leonard plan their future.', 0, 'webseries'),
(93, 'The Big Bang Theory - Season 9', 2015, '8.0', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'Penny and Leonard marry, Sheldon and Amy redefine their relationship.', 0, 'webseries'),
(94, 'The Big Bang Theory - Season 10', 2016, '8.1', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'Sheldon and Amy move in together, family members join the story.', 1, 'webseries'),
(95, 'The Big Bang Theory - Season 11', 2017, '8.2', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'Sheldon and Amy get engaged, others face big life changes.', 0, 'webseries'),
(96, 'The Big Bang Theory - Season 12', 2018, '8.3', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'The final season concludes with Sheldon and Amy’s Nobel Prize win.', 1, 'webseries');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--
DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_media_like_unique` (`user_id`,`media_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--
INSERT IGNORE INTO `likes` (`user_id`, `media_id`) VALUES
(1, 2), (2, 2), (3, 2), -- The Dark Knight (3 Likes)
(1, 1), (2, 1), -- Inception (2 Likes)
(1, 13), (3, 13), -- The Shawshank Redemption (2 Likes)
(1, 11), -- Breaking Bad (1 Like)
(2, 3); -- Interstellar (1 Like)

-- --------------------------------------------------------

-- (Add other CREATE TABLE statements for watchlist, plans, etc. here if needed)

ALTER TABLE `users` AUTO_INCREMENT = 4;
ALTER TABLE `media` AUTO_INCREMENT = 15;
ALTER TABLE `likes` AUTO_INCREMENT = 1;


INSERT INTO `plans` (`id`, `name`, `price`, `billing_cycle`, `features`, `is_popular`) VALUES
(5, 'Basic Annual', 99.99, 'annual', 'Good video quality (720p);Watch on 1 device at a time', 0),
(6, 'Standard Annual', 159.99, 'annual', 'Great video quality (1080p);Watch on 2 devices at a time', 0),
(7, 'Diamond Annual', 199.99, 'annual', 'Best video quality (4K+HDR);Watch on 4 devices at a time', 0),
(8, 'Diamond+ Annual', 259.99, 'annual', 'Ultimate video quality (4K+HDR);Watch on 6 devices at a time', 0);



INSERT INTO `subscriptions` (`id`, `name`, `price`, `billing_cycle`, `features`, `is_popular`) VALUES
(1, 'Basic', 9.99, 'monthly', 'Good video quality (720p);Watch on 1 device at a time', 0),
(2, 'Standard', 15.99, 'monthly', 'Great video quality (1080p);Watch on 2 devices at a time', 0),
(3, 'Diamond', 19.99, 'monthly', 'Best video quality (4K+HDR);Watch on 4 devices at a time', 1),
(4, 'Diamond+', 25.99, 'monthly', 'Ultimate video quality (4K+HDR);Watch on 6 devices at a time', 0),
(5, 'Basic Annual', 99.99, 'annual', 'Good video quality (720p);Watch on 1 device at a time', 0),
(6, 'Standard Annual', 159.99, 'annual', 'Great video quality (1080p);Watch on 2 devices at a time', 0),
(7, 'Diamond Annual', 199.99, 'annual', 'Best video quality (4K+HDR);Watch on 4 devices at a time', 0),
(8, 'Diamond+ Annual', 259.99, 'annual', 'Ultimate video quality (4K+HDR);Watch on 6 devices at a time', 0);
