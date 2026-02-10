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
(6, 'Breaking Bad', 2008, '9.5', 'https://image.tmdb.org/t/p/w500/ggFHVNu6YYI5L9pCfOacjizRGt.jpg', 'A high school chemistry teacher diagnosed with inoperable lung cancer turns to manufacturing and selling methamphetamine.', 1, 'web-series'),
(7, 'The Shawshank Redemption', 1994, '9.3', 'https://image.tmdb.org/t/p/w500/q6y0Go1tsGEsmtFryDOJo3dEmq.jpg', 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.', 0, 'movie'),
(8, 'The Godfather', 1972, '9.2', 'https://image.tmdb.org/t/p/w500/3bhkrj58Vtu7enYsRolD1fZdja1.jpg', 'The aging patriarch of an an organized crime dynasty transfers control of his clandestine empire to his reluctant son.', 1, 'movie');
(9, 'Joker', 2019, '8.4', 'https://image.tmdb.org/t/p/w500/udDclJoHjfjb8Ekgsd4FDteOkCU.jpg', 'A failed comedian descends into madness.', 1, 'movie'),
(10, 'Money Heist', 2017, '8.3', 'https://image.tmdb.org/t/p/w500/reEMJA1uzscCbkpeRJeTT2bjqUp.jpg', 'A mastermind leads a heist on Spain''s Mint.', 1, 'webseries'),
(11, 'The Mandalorian', 2019, '8.7', 'https://image.tmdb.org/t/p/w500/sWgBv7LV2PRoQgkxwlibdGXKz1S.jpg', 'A lone gunfighter in the outer reaches of the galaxy.', 1, 'webseries'),
(12, 'Parasite', 2019, '8.5', 'https://image.tmdb.org/t/p/w500/7IiTTgloJzvGI1TAYymCfbfl3vT.jpg', 'A poor family infiltrates a wealthy household.', 1, 'movie'),
(13, 'Peaky Blinders', 2013, '8.8', 'https://image.tmdb.org/t/p/w500/bGZn5RVzMMXju4ev7xbl1aLdXqq.jpg', 'A gangster family in 1900s England.', 1, 'webseries'),
(14, 'Inception', 2010, '8.8', 'https://image.tmdb.org/t/p/w500/edv5CZvWj09upOsy2Y6IwDhK8bt.jpg', 'A thief enters dreams to steal secrets but must pull off one last impossible job.', 1, 'movie'),
(15, 'Fight Club', 1999, '8.8', 'https://image.tmdb.org/t/p/w500/bptfVGEQuv6vDTIMVCHjJ9Dz8PX.jpg', 'An insomniac office worker and a soapmaker form an underground fight club.', 0, 'movie'),
(16, 'Pulp Fiction', 1994, '8.9', 'https://image.tmdb.org/t/p/w500/dM2w364MScsjFf8pfMbaWUcWrR.jpg', 'The lives of two hitmen, a boxer, and others intertwine in violent tales.', 1, 'movie'),
(17, 'Forrest Gump', 1994, '8.8', 'https://image.tmdb.org/t/p/w500/saHP97rTPS5eLmrLQEcANmKrsFl.jpg', 'The story of Forrest Gump, a man with a low IQ who influences key moments in history.', 0, 'movie'),
(18, 'The Matrix', 1999, '8.7', 'https://image.tmdb.org/t/p/w500/f89U3ADr1oiB1s9GkdPOEpXUk5H.jpg', 'A hacker learns the shocking truth about his reality and his role in the war against its controllers.', 1, 'movie'),
(19, 'Interstellar', 2014, '8.6', 'https://image.tmdb.org/t/p/w500/rAiYTfKGqDCRIIqo664sY9XZIvQ.jpg', 'A group of explorers travel through a wormhole in search of a new home for humanity.', 0, 'movie'),
(20, 'Parasite', 2019, '8.5', 'https://image.tmdb.org/t/p/w500/7IiTTgloJzvGI1TAYymCfbfl3vT.jpg', 'A poor family infiltrates a wealthy household with unexpected consequences.', 1, 'movie'),
(21, 'Avengers: Endgame', 2019, '8.4', 'https://image.tmdb.org/t/p/w500/or06FN3Dka5tukK1e9sl16pB3iy.jpg', 'The Avengers assemble for a final showdown against Thanos.', 1, 'movie'),
(22, 'Breaking Bad', 2008, '9.5', 'https://image.tmdb.org/t/p/w500/ggFHVNu6YYI5L9pCfOacjizRGt.jpg', 'A chemistry teacher diagnosed with cancer begins manufacturing meth.', 1, 'webseries'),
(23, 'Stranger Things', 2016, '8.7', 'https://image.tmdb.org/t/p/w500/x2LSRK2Cm7MZhjluni1msVJ3wDF.jpg', 'A group of kids uncover supernatural mysteries in a small town.', 0, 'webseries'),
(24, 'Game of Thrones', 2011, '9.3', 'https://image.tmdb.org/t/p/w500/u3bZgnGQ9T01sWNhyveQz0wH0Hl.jpg', 'Noble families vie for control of the Iron Throne of Westeros.', 1, 'webseries'),
(25, 'The Witcher', 2019, '8.2', 'https://image.tmdb.org/t/p/w500/7vjaCdMw15FEbXyLQTVa04URsPm.jpg', 'A monster hunter struggles to find his place in a world where people can be worse than beasts.', 0, 'webseries'),
(26, 'Money Heist', 2017, '8.3', 'https://image.tmdb.org/t/p/w500/reEMJA1uzscCbkpeRJeTT2bjqUp.jpg', 'A criminal mastermind and his team plan the biggest heist in history.', 1, 'webseries'),
(27, 'Chernobyl', 2019, '9.4', 'https://image.tmdb.org/t/p/w500/hlLXt2tOPT6RRnjiUmoxyG1LTFi.jpg', 'The true story of one of the worst man-made disasters in history.', 0, 'webseries'),
(28, 'The Boys', 2019, '8.7', 'https://image.tmdb.org/t/p/w500/mY7SeH4HFFxW1hiI6cWuwCRKptN.jpg', 'A group of vigilantes take on corrupt superheroes.', 1, 'webseries'),
(29, 'Peaky Blinders', 2013, '8.8', 'https://image.tmdb.org/t/p/w500/bGZn5RVzMMXju4ev7xbl1aLdXqq.jpg', 'A gangster family epic set in 1900s England.', 0, 'webseries');
(30, 'Lucifer', 2016, '8.1', 'https://image.tmdb.org/t/p/w500/ekZobS8isE6mA53RAiGDG93hBxL.jpg', 'The Devil abandons Hell and runs a nightclub in Los Angeles while helping the LAPD.', 1, 'webseries'),
(31, 'Narcos', 2015, '8.8', 'https://image.tmdb.org/t/p/w500/rTmal9fDbwh5F0waol2hq35U4ah.jpg', 'The true-life stories of Colombia’s drug lords and the DEA agents fighting them.', 0, 'webseries'),
(32, 'Frozen', 2013, '7.5', 'https://image.tmdb.org/t/p/w500/kgwjIb2JDHRhNk13lw6uUbrhDdM.jpg', 'Two sisters fight to save their kingdom from eternal winter.', 1, 'movie'),
(33, 'Iron Man', 2008, '7.9', 'https://image.tmdb.org/t/p/w500/78lPtwv72eTNqFW9COBYI0dWDJa.jpg', 'Tony Stark builds a high-tech suit of armor to save his life and fight evil.', 1, 'movie'),
(34, 'Vikings', 2013, '8.5', 'https://image.tmdb.org/t/p/w500/aq2yM8KyxB7b3h4gTHoAu8jT5r6.jpg', 'The legendary saga of Ragnar Lothbrok and his Viking warriors.', 0, 'webseries');
(35, 'Lost', 2004, '8.3', 'https://image.tmdb.org/t/p/w500/ogM2hzWNoJg9RTxwIdUuVo1yECL.jpg', 'Survivors of a plane crash face mysteries on an island.', 0, 'webseries'),
(36, 'Avatar', 2009, '7.9', 'https://image.tmdb.org/t/p/w500/jRXYjXNq0Cs2TcJjLkki24MLp7u.jpg', 'A paraplegic marine on an alien planet joins its people.', 1, 'movie'),
(37, 'The Office', 2005, '9.0', 'https://image.tmdb.org/t/p/w500/qWnJzyZhyy74gjpSjIXWmuk0ifX.jpg', 'A mockumentary on office workers in Scranton.', 0, 'webseries'),
(38, 'Friends', 1994, '8.9', 'https://image.tmdb.org/t/p/w500/f496cm9enuEsZkSPzCwnTESEK5s.jpg', 'Six friends navigate life and love in New York City.', 0, 'webseries'),
(39, 'Severance', 2022, '8.6', 'https://image.tmdb.org/t/p/w500/ugvV5Z5SzzQ3CFAmDvj8BqCkN44.jpg', 'Employees undergo a procedure that separates work and personal memories.', 1, 'webseries'),
(40, 'The Simpsons', 1989, '8.7', 'https://image.tmdb.org/t/p/w500/zI3E2a3WYma5w8emI35mgq5Iurx.jpg', 'Animated comedy about a dysfunctional family.', 0, 'webseries'),
(41, 'The Avengers', 2012, '8.0', 'https://image.tmdb.org/t/p/w500/RYMX2wcKCBAr24UyPD7xwmjaTn.jpg', 'Earth’s mightiest heroes assemble to fight Loki.', 1, 'movie'),
(42, 'The Big Bang Theory', 2007, '8.1', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'A group of nerdy friends navigate life and science.', 0, 'webseries'),
(43, 'Squid Game', 2021, '8.2', 'https://image.tmdb.org/t/p/w500/dDlEmu3EZ0Pgg93K2SVNLCjCSvE.jpg', 'Hundreds compete in deadly games for money.', 1, 'webseries'),
(44, 'Titanic', 1997, '7.9', 'https://image.tmdb.org/t/p/w500/9xjZS2rlVxm8SFx8kPC3aIGCOYQ.jpg', 'A romance blossoms on the ill-fated Titanic.', 0, 'movie'),
(45, 'The Flash', 2014, '7.6', 'https://image.tmdb.org/t/p/w500/lJA2RCMfsWoskqlQhXPSLFQGXEJ.jpg', 'Barry Allen becomes the fastest man alive.', 0, 'webseries'),
(46, 'Loki', 2021, '8.2', 'https://image.tmdb.org/t/p/w500/kEl2t3OhXc3Zb9FBh1AuYzRTgZp.jpg', 'The God of Mischief steps out of his brother’s shadow.', 1, 'webseries'),
(47, 'Doctor Strange', 2016, '7.5', 'https://image.tmdb.org/t/p/w500/gwi5kYyqS7ZlDoN0fTguSuWj5DC.jpg', 'A surgeon discovers mystic arts after an accident.', 1, 'movie'),
(48, 'The Social Network', 2010, '7.8', 'https://image.tmdb.org/t/p/w500/n0ybibhJtQ5icDqTp8eRytcIHJx.jpg', 'The story of the founding of Facebook.', 0, 'movie');
(49, 'Sanam Teri Kasam', 2016, '7.5', 'https://image.tmdb.org/t/p/w500/v3pbMbeqPfq7uR3vY9VOGQsv5nR.jpg', 'A tragic love story between a misunderstood boy and a girl longing for acceptance.', 0, 'movie');
(50, '3 Idiots', 2009, '8.4', 'https://image.tmdb.org/t/p/w500/66i9Mk2t1Ik5dUvNbKQ5E5rXPvs.jpg', 'Three friends challenge the education system in India.', 1, 'movie'),
(51, 'Dangal', 2016, '8.4', 'https://image.tmdb.org/t/p/w500/xq5J4Pw8yg1OQ9UfzWkP2YBz4sQ.jpg', 'A father trains his daughters to become world-class wrestlers.', 1, 'movie'),
(52, 'Gully Boy', 2019, '8.0', 'https://image.tmdb.org/t/p/w500/8j58iEBw9pOXFD2L0nt0ZXeHviB.jpg', 'A street rapper rises from Mumbai slums.', 0, 'movie'),
(53, 'Lagaan', 2001, '8.1', 'https://image.tmdb.org/t/p/w500/8l5l7Z4SO6L58LdzbuzpAo7P5PL.jpg', 'Villagers challenge British rulers to a game of cricket.', 1, 'movie'),
(54, 'PK', 2014, '8.1', 'https://image.tmdb.org/t/p/w500/kBf3g9crrADGMc2AMAMlLBgSm2h.jpg', 'An alien questions blind faith in India.', 0, 'movie'),
(55, 'Zindagi Na Milegi Dobara', 2011, '8.2', 'https://image.tmdb.org/t/p/w500/l2tQ0jz5iI4vGUtkWxppIqhzyzk.jpg', 'Three friends go on a road trip of self-discovery.', 1, 'movie'),
(56, 'Kabir Singh', 2019, '7.0', 'https://image.tmdb.org/t/p/w500/5aGhaIHYuQbqlHWvWYqMCnj40y2.jpg', 'A brilliant but self-destructive surgeon spirals after heartbreak.', 0, 'movie'),
(57, 'Shershaah', 2021, '8.4', 'https://image.tmdb.org/t/p/w500/6cx2prDq7QWqFrrcq6Y3rO1eE8O.jpg', 'Biopic of Captain Vikram Batra, a Kargil war hero.', 1, 'movie'),
(58, 'Article 15', 2019, '8.2', 'https://image.tmdb.org/t/p/w500/9JGHJsbgx5caGV5WDHnhbIVdQyE.jpg', 'An IPS officer investigates caste-based discrimination.', 1, 'movie'),
(59, 'Andhadhun', 2018, '8.3', 'https://image.tmdb.org/t/p/w500/oYrKfdH37EqMaRMuMJnqd7qV3Cy.jpg', 'A blind pianist is caught in a murder mystery.', 0, 'movie'),
(60, 'Barfi!', 2012, '8.1', 'https://image.tmdb.org/t/p/w500/sQSMVXni1VlzDqgW8sELpAoCYXM.jpg', 'A mute and deaf man''s love story full of innocence.', 1, 'movie'),
(61, 'Chakde! India', 2007, '8.2', 'https://image.tmdb.org/t/p/w500/8CXvQydb9h9NP7VDaRao7IhiHBp.jpg', 'A disgraced hockey player coaches the Indian women’s team.', 0, 'movie'),
(62, 'Taare Zameen Par', 2007, '8.4', 'https://image.tmdb.org/t/p/w500/sHJEuwZy4v5n7Zt9JcYy1o6xp6o.jpg', 'A teacher helps a dyslexic child discover his true potential.', 1, 'movie'),
(63, 'Queen', 2013, '8.1', 'https://image.tmdb.org/t/p/w500/bmX7hwgoonZMCGgxORs5KqsNRbR.jpg', 'A young woman embarks on a solo honeymoon trip to Europe.', 0, 'movie'),
(64, 'Dil Chahta Hai', 2001, '8.1', 'https://image.tmdb.org/t/p/w500/jvyWSrFubXDU7wgnWbrZwrHgMHx.jpg', 'Three inseparable childhood friends face adulthood changes.', 1, 'movie'),
(65, 'Kal Ho Naa Ho', 2003, '8.0', 'https://image.tmdb.org/t/p/w500/vzS6O8tZTna8fDcSu7tYvK0Y3R0.jpg', 'A dying man teaches a woman to embrace life and love.', 0, 'movie'),
(66, 'My Name Is Khan', 2010, '8.0', 'https://image.tmdb.org/t/p/w500/u8sW0H0TADaBrZEcD3xKhsR4H2v.jpg', 'A man with Asperger’s embarks on a journey to meet the U.S. President.', 1, 'movie'),
(67, 'Bhaag Milkha Bhaag', 2013, '8.2', 'https://image.tmdb.org/t/p/w500/rdyz8xmPKzW0fvkYhpQ2cEeoBHw.jpg', 'The story of athlete Milkha Singh’s struggles and triumphs.', 1, 'movie'),
(68, 'Rockstar', 2011, '7.7', 'https://image.tmdb.org/t/p/w500/pG0rzG32IOzBSSMSmc5QwDFi1C5.jpg', 'A musician’s passion and heartbreak shape his journey.', 0, 'movie'),
(69, 'Padmaavat', 2018, '7.0', 'https://image.tmdb.org/t/p/w500/7sOIuVkkpFmS6r30YIOCQM7DDDe.jpg', 'The story of Queen Padmavati and Alauddin Khilji.', 1, 'movie'),
(70, 'Jab We Met', 2007, '7.9', 'https://image.tmdb.org/t/p/w500/fvY0RduCMsZqiXXdK5vC41HKvZN.jpg', 'A depressed businessman meets a free-spirited girl on a train journey.', 0, 'movie'),
(71, 'Drishyam', 2015, '8.2', 'https://image.tmdb.org/t/p/w500/zTz9F8j2dZbW9nMXzXgZAjtZ4Vn.jpg', 'A man uses his wit to save his family after a crime.', 1, 'movie'),
(72, 'Pink', 2016, '8.1', 'https://image.tmdb.org/t/p/w500/8N2VNivX5hJ9V7H5P4xM4gJmU16.jpg', 'A courtroom drama that questions societal judgment of women.', 0, 'movie'),
(73, 'Super 30', 2019, '7.9', 'https://image.tmdb.org/t/p/w500/6n6yMfdbPEZ7x1YgnSUZXoqBYw7.jpg', 'A teacher trains underprivileged students for IIT exams.', 1, 'movie'),
(74, 'Stree', 2018, '7.5', 'https://image.tmdb.org/t/p/w500/g7c8y3r4gJwg7p3NzcEBjXJfLQ2.jpg', 'A small town is haunted by a mysterious female spirit.', 0, 'movie'),
(75, 'Sacred Games', 2018, '8.6', 'https://image.tmdb.org/t/p/w500/2w6VYLRh1SeIKMqz4tWl6Q0x3dJ.jpg', 'A cop uncovers a crime lord’s deadly conspiracy in Mumbai.', 1, 'webseries'),
(76, 'Delhi Crime', 2019, '8.5', 'https://image.tmdb.org/t/p/w500/wiu9HcFn3AdVwGv61U4bku2AzL5.jpg', 'Based on the 2012 Delhi gang rape case investigation.', 1, 'webseries'),
(77, 'Made in Heaven', 2019, '8.3', 'https://image.tmdb.org/t/p/w500/eqzA94ppWKqhzyapMI2vlA38nS9.jpg', 'Wedding planners navigate traditions and modern conflicts.', 0, 'webseries'),
(78, 'Mirzapur', 2018, '8.5', 'https://image.tmdb.org/t/p/w500/50Lr7Y2vDLteA94ppLvhJN9Wew5.jpg', 'Power struggles and crime in a small town in Uttar Pradesh.', 1, 'webseries'),
(79, 'Paatal Lok', 2020, '8.0', 'https://image.tmdb.org/t/p/w500/8aVwN0h3hFCXohM3ULICwhf66A3.jpg', 'A cop investigates a case leading to dark secrets of society.', 0, 'webseries');
(80, 'The Big Bang Theory - Season 2', 2008, '8.2', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'Leonard pursues Penny while Sheldon’s quirks shine brighter.', 0, 'webseries'),
(81, 'The Big Bang Theory - Season 3', 2009, '8.3', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'Penny and Leonard’s relationship deepens as Sheldon finds new challenges.', 0, 'webseries'),
(82, 'The Big Bang Theory - Season 4', 2010, '8.1', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'New characters like Amy and Bernadette join, changing group dynamics.', 1, 'webseries'),
(83, 'The Big Bang Theory - Season 5', 2011, '8.2', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'Romantic relationships evolve with Sheldon and Amy, Leonard and Penny.', 0, 'webseries'),
(84, 'The Big Bang Theory - Season 6', 2012, '8.1', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'Howard goes to space and relationships continue to grow.', 0, 'webseries'),
(85, 'The Big Bang Theory - Season 7', 2013, '8.3', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'Sheldon faces personal growth challenges as Penny commits to acting.', 1, 'webseries'),
(86, 'The Big Bang Theory - Season 8', 2014, '8.1', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'Sheldon’s trip changes his perspective, Penny and Leonard plan their future.', 0, 'webseries'),
(87, 'The Big Bang Theory - Season 9', 2015, '8.0', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'Penny and Leonard marry, Sheldon and Amy redefine their relationship.', 0, 'webseries'),
(88, 'The Big Bang Theory - Season 10', 2016, '8.1', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'Sheldon and Amy move in together, family members join the story.', 1, 'webseries'),
(89, 'The Big Bang Theory - Season 11', 2017, '8.2', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'Sheldon and Amy get engaged, others face big life changes.', 0, 'webseries'),
(90, 'The Big Bang Theory - Season 12', 2018, '8.3', 'https://image.tmdb.org/t/p/w500/ooBGRQBdbGzBxAVfExiO8r7kloA.jpg', 'The final season concludes with Sheldon and Amy’s Nobel Prize win.', 1, 'webseries');


INSERT INTO `media` (`id`, `title`, `year`, `rating`, `poster`, `description`, `trailer_url`, `exclusive`, `type`) VALUES
(157, 'Superbad', 2007, '7.6', 'https://image.tmdb.org/t/p/w500/ek8oQ4eGwezDDbkvo6b43wZitg7.jpg', 'Two co-dependent high school seniors are forced to deal with separation anxiety after their plan to stage a booze-soaked party goes awry.',  0, 'comedy'),
(158, 'The Hangover', 2009, '7.5', 'https://image.tmdb.org/t/p/w500/sA6f84d23aK36p22a0r3k4aI6gG.jpg', 'Three buddies wake up from a bachelor party in Las Vegas, with no memory of the previous night and the bachelor missing.', 0, 'comedy'),
(159, 'Step Brothers', 2008, '6.9', 'https://image.tmdb.org/t/p/w500/tD62qJp2sqHl8Wk6o5g2a5aA2s.jpg', 'Two aimless middle-aged losers still living at home are forced against their will to become roommates when their parents marry.', 0, 'comedy'),
(160, 'Booksmart', 2019, '7.1', 'https://image.tmdb.org/t/p/w500/gBaw2WcMry21s2N2gHhR8s1s8g.jpg', 'On the eve of their high school graduation, two academic superstars and best friends realize they should have worked less and played more.', 1, 'comedy'),
(161, '21 Jump Street', 2012, '6.9', 'https://image.tmdb.org/t/p/w500/uhpqs1kdtc4p9M3wslV5nS5a1M.jpg', 'A pair of underachieving cops are sent back to a local high school to blend in and bring down a synthetic drug ring.', 0, 'comedy'),
(162, 'Anchorman: The Legend of Ron Burgundy', 2004, '6.9', 'https://image.tmdb.org/t/p/w500/it2m2kg5lBzae2DAv2jLLd1j7s.jpg', 'Ron Burgundy is San Diego''s top-rated newsman in the male-dominated broadcasting of the 1970s, but that''s all about to change for Ron and his cronies.', 0, 'comedy'),
(163, 'Tropic Thunder', 2008, '6.6', 'https://image.tmdb.org/t/p/w500/8Vzs2t23P1hA3Fz92Q3g8M2gKfi.jpg', 'Through a series of freak occurrences, a group of actors shooting a big-budget war movie are forced to become the soldiers they are portraying.', 1, 'comedy'),
(164, 'Shaun of the Dead', 2004, '7.9', 'https://image.tmdb.org/t/p/w500/2L5s2f4g4aRCSd2i4zfnG26QjYk.jpg', 'A man decides to turn his moribund life around by winning back his ex-girlfriend, reconciling his relationship with his mother, and dealing with an entire community that has returned from the dead to eat the living.', 0, 'comedy'),
(165, 'Hot Fuzz', 2007, '7.8', 'https://image.tmdb.org/t/p/w500/8g1c3aDb95t1kpgk33Cg1n5fTde.jpg', 'A skilled London police officer is transferred to a small town with a dark secret.', 0, 'comedy'),
(166, 'Forgetting Sarah Marshall', 2008, '6.7', 'https://image.tmdb.org/t/p/w500/h52VR6p363dGAd2K0NcyTfCemc6.jpg', 'Devastated Peter takes a Hawaiian vacation in order to deal with the recent break-up with his TV star girlfriend, Sarah.', 0, 'comedy'),
(167, 'Bridesmaids', 2011, '6.5', 'https://image.tmdb.org/t/p/w500/3oQ4tZwd1iZ3dCq5LzfaM8OA5w.jpg', 'Competition between the maid of honor and a bridesmaid, over who is the bride''s best friend, threatens to upend the life of an out-of-work pastry chef.', 0, 'comedy'),
(168, 'The Other Guys', 2010, '6.3', 'https://image.tmdb.org/t/p/w500/52gLi8h5z9F8g2j2oA53Qer32iS.jpg', 'Two mismatched New York City detectives seize an opportunity to step up like the city''s top cops whom they idolize -- only things don''t quite go as planned.', 0, 'comedy'),
(169, 'Dumb and Dumber', 1994, '7.2', 'https://image.tmdb.org/t/p/w500/4LdpBXiCyA5d36eIe2n02s4gYy.jpg', 'After a woman leaves a briefcase at the airport terminal, a dumb limo driver and his dumber friend set out on a cross-country road trip to Aspen to return it.', 0, 'comedy'),
(170, 'Office Space', 1999, '7.4', 'https://image.tmdb.org/t/p/w500/iL3r3r34i64mly98D02K4a2q1AY.jpg', 'Three company workers who hate their jobs decide to rebel against their greedy boss.', 1, 'comedy'),
(171, 'Zoolander', 2001, '6.2', 'https://image.tmdb.org/t/p/w500/3EAYxdCfC9d23S3jJgq0a92P53.jpg', 'At the end of his career, a clueless fashion model is brainwashed to kill the Prime Minister of Malaysia.', 0, 'comedy'),
(172, 'The Big Lebowski', 1998, '8.2', 'https://image.tmdb.org/t/p/w500/hEtb3I33h3232deCgK1sOchv2j.jpg', 'Jeff "The Dude" Lebowski, mistaken for a millionaire of the same name, seeks restitution for his ruined rug and enlists his bowling buddies to help.', 0, 'comedy'),
(173, 'Airplane!', 1980, '7.3', 'https://image.tmdb.org/t/p/w500/1YsY2h0K5s0z6s0SCS2ruaL4A2w.jpg', 'An ex-fighter pilot must take over the controls of an airliner when the flight crew succumbs to food poisoning.', 0, 'comedy'),
(174, 'Monty Python and the Holy Grail', 1975, '7.8', 'https://image.tmdb.org/t/p/w500/3Kz3hA5d3myTf4fl222s3eIeZ0T.jpg', 'King Arthur and his Knights of the Round Table embark on a surreal, low-budget search for the Holy Grail, encountering many very silly obstacles.', 0, 'comedy'),
(175, 'Groundhog Day', 1993, '7.7', 'https://image.tmdb.org/t/p/w500/gS9Q2i0J86iZcgh9fWf0e9OK2a.jpg', 'A weatherman finds himself inexplicably living the same day over and over again.', 0, 'comedy'),
(176, 'Ghostbusters', 1984, '7.4', 'https://image.tmdb.org/t/p/w500/u1v5m2W1eAfRde3m4uL2yKAFgK.jpg', 'Three former parapsychology professors set up shop as a unique ghost removal service.', 0, 'comedy'),
(177, 'Ferris Bueller''s Day Off', 1986, '7.5', 'https://image.tmdb.org/t/p/w500/4GII5mykBG32Mru8M2Hh0cfzaL.jpg', 'A high school wise guy is determined to have a day off from school, despite what the principal thinks of that.', 0, 'comedy'),
(178, 'Clerks', 1994, '7.4', 'https://image.tmdb.org/t/p/w500/3sZ2ca2bSrmpB39KTYAf3aCRq3c.jpg', 'A day in the lives of two convenience clerks named Dante and Randal as they annoy customers, discuss movies, and play hockey on the store roof.', 1, 'comedy'),
(179, 'The 40-Year-Old Virgin', 2005, '6.4', 'https://image.tmdb.org/t/p/w500/uUA63e4GNu1nO0p42y2sdr52G2.jpg', 'Goaded by his buddies, a nerdy 40-year-old virgin who works in an electronics store tunes up his "game" with the help of his friends.', 0, 'comedy'),
(180, 'Borat', 2006, '6.7', 'https://image.tmdb.org/t/p/w500/prZ8a130oI7Qx1Pj25H1t1gwA0.jpg', 'Kazakh TV talking head Borat is dispatched to the United States to report on the greatest country in the world.', 1, 'comedy'),
(181, 'Knocked Up', 2007, '6.2', 'https://image.tmdb.org/t/p/w500/uFdl0JPvj1mZ2dsoz2F0f2yqrr.jpg', 'For fun-loving party animal Ben Stone, the last thing he ever expected was for his one-night stand to show up on his doorstep eight weeks later to tell him she''s pregnant.', 0, 'comedy'),
(182, 'Juno', 2007, '7.0', 'https://image.tmdb.org/t/p/w500/gH0i2RaO5FtrP1i35dCq3vG29C.jpg', 'Faced with an unplanned pregnancy, an offbeat young woman makes an unusual decision regarding her unborn child.', 0, 'comedy'),
(183, 'Little Miss Sunshine', 2006, '7.5', 'https://image.tmdb.org/t/p/w500/6v7g2Tvkd1Q3g24T2s0a5y37vM.jpg', 'A family determined to get their young daughter into the finals of a beauty pageant take a cross-country trip in their VW bus.', 0, 'comedy'),
(184, 'Sideways', 2004, '7.0', 'https://image.tmdb.org/t/p/w500/5WkY2gkyu21aUDlWk9tDkAnwM8.jpg', 'Two men reaching middle age with not much to show but failure embark on a week-long road trip through California''s wine country.', 0, 'comedy'),
(185, 'Galaxy Quest', 1999, '7.1', 'https://image.tmdb.org/t/p/w500/8dIAb13s122uGIwz7nPf1tu223.jpg', 'The alumni cast of a space opera television series have to play their roles as the real thing when an alien race needs their help.', 0, 'comedy'),
(186, 'Crazy, Stupid, Love.', 2011, '7.2', 'https://image.tmdb.org/t/p/w500/a7zJ21Q0iB383m06hSuKj2t1zGO.jpg', 'A middle-aged husband''s life changes dramatically when his wife asks him for a divorce. He seeks to rediscover his manhood with the help of a newfound friend.', 0, 'comedy'),
(187, 'Easy A', 2010, '6.8', 'https://image.tmdb.org/t/p/w500/a35G05t5G5iayzYrhYgmkSHxW7.jpg', 'A clean-cut high school student relies on the school''s rumor mill to advance her social and financial standing.', 0, 'comedy'),
(188, 'This Is the End', 2013, '6.2', 'https://image.tmdb.org/t/p/w500/hEvMT4y8eJT0o8iAqhK1sXn0sC.jpg', 'A group of Hollywood celebrities stuck together in a house after a series of strange and catastrophic events devastate Los Angeles.', 0, 'comedy'),
(189, 'Popstar: Never Stop Never Stopping', 2016, '6.6', 'https://image.tmdb.org/t/p/w500/89S0iOQL3pT64yC9sZ6jEV5B5a.jpg', 'When it becomes clear that his solo album is a failure, a former boy band member does everything in his power to maintain his celebrity status.', 0, 'comedy'),
(190, 'The Nice Guys', 2016, '7.2', 'https://image.tmdb.org/t/p/w500/hmtu2g62Jpl8AQsHdj2sCDAnWJ.jpg', 'A mismatched pair of private eyes investigate the apparent suicide of a fading porn star in 1970s Los Angeles.', 1, 'comedy'),
(191, 'Game Night', 2018, '6.9', 'https://image.tmdb.org/t/p/w500/9T13QJgI1aTj3pk2A2iS0iAdgX.jpg', 'A group of friends who meet regularly for game nights find themselves trying to solve a murder mystery.', 0, 'comedy'),
(192, 'The Death of Stalin', 2017, '7.3', 'https://image.tmdb.org/t/p/w500/3dFf3v2aTSdD1j2wPLp4n4RILv.jpg', 'Follows the Soviet dictator''s last days and depicts the chaos of the regime after his death.', 1, 'comedy'),
(193, 'What We Do in the Shadows', 2014, '7.6', 'https://image.tmdb.org/t/p/w500/yQ07Wg1oHgSDi535g4yvA0g3xL.jpg', 'A documentary team films the lives of a group of vampires for a few months.', 0, 'comedy'),
(194, 'Singin'' in the Rain', 1952, '8.2', 'https://image.tmdb.org/t/p/w500/73o7sK2GgGuYvCgUxr2l5eJbA7.jpg', 'A silent film star falls for a chorus girl just as he and his delusionally jealous screen partner are trying to make the difficult transition to talking pictures in 1920s Hollywood.', 0, 'comedy'),
(195, 'Dr. Strangelove', 1964, '8.3', 'https://image.tmdb.org/t/p/w500/p4So5cJP1uM9eWqrYy42h9x1aK.jpg', 'An insane general triggers a path to nuclear holocaust that a war room full of politicians and generals frantically tries to stop.', 0, 'comedy'),
(196, 'Some Like It Hot', 1959, '8.1', 'https://image.tmdb.org/t/p/w500/p4So5cJP1uM9eWqrYy42h9x1aK.jpg', 'When two male musicians witness a mob hit, they flee the state in an all-female band disguised as women, but further complications set in.', 0, 'comedy'),
(197, 'The Apartment', 1960, '8.2', 'https://image.tmdb.org/t/p/w500/p4So5cJP1uM9eWqrYy42h9x1aK.jpg', 'A man tries to rise in his company by letting its executives use his apartment for trysts, but complications and a romance of his own ensue.', 0, 'comedy'),
(198, 'Tootsie', 1982, '7.4', 'https://image.tmdb.org/t/p/w500/p4So5cJP1uM9eWqrYy42h9x1aK.jpg', 'An unemployed actor with a reputation for being difficult lands a role in a popular soap opera by pretending to be a woman.', 0, 'comedy'),
(199, 'When Harry Met Sally...', 1989, '7.4', 'https://image.tmdb.org/t/p/w500/p4So5cJP1uM9eWqrYy42h9x1aK.jpg', 'Harry and Sally have known each other for years, and are very good friends, but they fear sex would ruin the friendship.', 0, 'comedy'),
(200, 'My Cousin Vinny', 1992, '7.5', 'https://image.tmdb.org/t/p/w500/p4So5cJP1uM9eWqrYy42h9x1aK.jpg', 'Two New Yorkers accused of murder in rural Alabama while on their way back to college call in the help of one of their cousins, a loudmouth lawyer with no trial experience.', 0, 'comedy'),
(201, 'Mean Girls', 2004, '7.0', 'https://image.tmdb.org/t/p/w500/p4So5cJP1uM9eWqrYy42h9x1aK.jpg', 'Cady Heron is a hit with The Plastics, the A-list girl clique at her new school, until she makes the mistake of falling for Aaron Samuels, the ex-boyfriend of alpha Plastic Regina George.', 0, 'comedy'),
(202, 'The Princess Bride', 1987, '8.0', 'https://image.tmdb.org/t/p/w500/p4So5cJP1uM9eWqrYy42h9x1aK.jpg', 'While home sick in bed, a young boy''s grandfather reads him the story of a farmboy-turned-pirate who encounters numerous obstacles, enemies and allies in his quest to be reunited with his true love.', 0, 'comedy'),
(203, 'Palm Springs', 2020, '7.4', 'https://image.tmdb.org/t/p/w500/p4So5cJP1uM9eWqrYy42h9x1aK.jpg', 'When carefree Nyles and reluctant maid of honor Sarah have a chance encounter at a Palm Springs wedding, things get complicated when they find themselves unable to escape the venue, themselves, or each other.', 1, 'comedy'),
(204, 'The Truman Show', 1998, '8.1', 'https://image.tmdb.org/t/p/w500/p4So5cJP1uM9eWqrYy42h9x1aK.jpg', 'An insurance salesman discovers his whole life is actually a reality TV show.', 0, 'comedy'),
(205, 'Shaolin Soccer', 2001, '7.0', 'https://image.tmdb.org/t/p/w500/p4So5cJP1uM9eWqrYy42h9x1aK.jpg', 'A young Shaolin follower reunites with his discouraged brothers to form a soccer team using their martial art skills to their advantage.', 0, 'comedy'),
(206, 'Kung Fu Hustle', 2004, '7.4', 'https://image.tmdb.org/t/p/w500/p4So5cJP1uM9eWqrYy42h9x1aK.jpg', 'In Shanghai, China in the 1940s, a wannabe gangster aspires to join the notorious "Axe Gang" while residents of a housing complex exhibit extraordinary powers in defending their turf.', 0, 'comedy');
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






-- Step 1: This command updates your 'media' table to allow 'comedy' as a type.
ALTER TABLE `media` MODIFY COLUMN `type` ENUM('movie', 'web-series', 'anime', 'bollywood', 'comedy') NOT NULL DEFAULT 'movie';

-- Step 2: This command inserts the 50 new comedy movies with their type set to 'comedy'.
