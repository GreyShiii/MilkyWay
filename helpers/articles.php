<?php
require_once __DIR__ . '/lang.php';

$ARTICLE_CATEGORIES = [
  [
    'slug' => 'what-is-breastfeeding',
    'name' => [
      'en'  => 'What is breastfeeding?',
      'fil' => 'Ano ang pagpapasuso?',
    ],
    'hero' => 'public/images/articles/categories/what_is_breastfeeding.jpg',
    'ribbon_class' => 'theme-intro',
  ],
  [
    'slug' => 'problems',
    'name' => [
      'en'  => 'Problems Encounter During Breastfeeding',
      'fil' => 'Mga Suliraning Nararanasan sa Pagpapasuso',
    ],
    'hero' => 'public/images/articles/categories/problems.jpg',
    'ribbon_class' => 'theme-problems',
  ],
  [
    'slug' => 'nutrition',
    'name' => [
      'en'  => 'Nutrition',
      'fil' => 'Nutrisyon',
    ],
    'hero' => 'public/images/articles/categories/nutrition.jpg',
    'ribbon_class' => 'theme-nutrition',
  ],
  [
    'slug' => 'tips',
    'name' => [
      'en'  => 'Breastfeeding Tips / Benefits',
      'fil' => 'Mga Tip / Benepisyo ng Pagpapasuso',
    ],
    'hero' => 'public/images/articles/categories/tips.jpg',
    'ribbon_class' => 'theme-tips',
  ],
  [
    'slug' => 'la',
    'name' => [
      'en'  => 'Latching & Attaching',
      'fil' => 'Tamang Latch at Pagdikit',
    ],
    'hero' => 'public/images/articles/categories/la.jpg',
    'ribbon_class' => 'theme-latch',
  ],
];

$ARTICLES = [

  [
    'id' => 1,
    'cat' => 'what-is-breastfeeding',
    'title' => 'Breastfeeding',
    'author' => 'WHO 2026',
    'thumb' => 'public/images/articles/thumbs/how-to-start.jpg',
    'overview' => 'Explains what breastfeeding is, how it works, how to start, and common concerns.',
    'link' => 'https://my.clevelandclinic.org/health/articles/15274-breastfeeding',
  ],

  [
    'id' => 2,
    'cat' => 'what-is-breastfeeding',
    'title' => 'Breastfeeding',
    'author' => 'World Health Organization',
    'thumb' => 'public/images/articles/thumbs/who.jpg',
    'overview' => 'WHO overview on breastfeeding benefits, recommendations, and global health impact.',
    'link' => 'https://www.who.int/health-topics/breastfeeding',
  ],

  [
    'id' => 3,
    'cat' => 'what-is-breastfeeding',
    'title' => 'Breastfeeding is best pero paano nga ba? ',
    'author' => 'UNICEF (2023)',
    'thumb' => 'public/images/articles/thumbs/unicef.jpg',
    'overview' => 'Tagalog guide discussing common breastfeeding problems and practical solutions.',
    'link' => 'https://www.unicef.org/philippines/stories/breastfeeding-best-pero-paano-nga-ba',
  ],

  [
    'id' => 4,
    'cat' => 'what-is-breastfeeding',
    'title' => 'Making Breastfeeding possible for mothers in every community ',
    'author' => 'UNICEF (2025)',
    'thumb' => 'public/images/articles/thumbs/unicef.jpg',
    'overview' => 'Making breastfeeding easy, possible, and celebrated in every community.',
    'link' => 'https://www.unicef.org/philippines/stories/making-breastfeeding-possible-mothers-every-community',
  ],

  // Problems 

  [
    'id' => 5,
    'cat' => 'problems',
    'title' => '5 common breastfeeding problems',
    'author' => 'UNICEF. (2023).',
    'thumb' => 'public/images/articles/thumbs/unicef.jpg',
    'overview' => 'Tackled the breastfeeding problems that the mother will be facing throughout her breastfeeding journey.',
    'link' => 'https://www.unicef.org/parenting/food-nutrition/5-common-breastfeeding-problems',
  ],

  [
    'id' => 6,
    'cat' => 'problems',
    'title' => 'Overcoming breastfeeding problems',
    'author' => 'MedlinePlus Medical Encyclopedia (2025)',
    'thumb' => 'public/images/articles/thumbs/unicef.jpg',
    'overview' => 'Shows different breastfeeding problems, how it occurred and what is the best practice for prevention and cure.',
    'link' => 'https://medlineplus.gov/ency/article/002452.htm',
  ],

  [
    'id' => 7,
    'cat' => 'problems',
    'title' => 'Five challenges moms might face while breastfeeding',
    'author' => 'Brandon (2019)',
    'thumb' => 'public/images/articles/thumbs/unicef.jpg',
    'overview' => 'Highlights how to cope up with challenges and how misperception affects breastfeeding. ',
    'link' => 'https://news.llu.edu/health-wellness/five-challenges-moms-might-face-while-breastfeeding',
  ],

  [
    'id' => 8,
    'cat' => 'problems',
    'title' => 'Overcoming Common Breastfeeding Challenges.',
    'author' => 'UCLA Med School (2023)',
    'thumb' => 'public/images/articles/thumbs/unicef.jpg',
    'overview' => ' Provide tips, tricks and advice on how to handle breastfeeding problems.',
    'link' => 'https://medschool.ucla.edu/news-article/overcoming-common-breastfeeding-challenges',
  ],

  [
    'id' => 9,
    'cat' => 'problems',
    'title' => 'The importance of breastfeeding and the challenges mothers face.',
    'author' => 'UNICEF (2024)',
    'thumb' => 'public/images/articles/thumbs/unicef.jpg',
    'overview' => 'shows how crucial the breastmilk for infants is, how it helps the newborn to become strong and healthy and develop a deeper bond between mother and infants.',
    'link' => 'https://www.unicef.org/angola/en/stories/importance-breastfeeding-and-challenges-mothers-face',
  ],

  [
    'id' => 10,
    'cat' => 'problems',
    'title' => 'Guest blog: The emotional experience of breastfeeding.',
    'author' => 'UNICEF. (2016)',
    'thumb' => 'public/images/articles/thumbs/unicef.jpg',
    'overview' => 'Tackled how emotions and experiences affect breastfeeding, such as hesitation and discouragement to continue breastfeeding and how confidence builds up through the support of the society.',
    'link' => 'https://www.unicef.org.uk/babyfriendly/emotional-experience-breastfeeding/',
  ],

  // Nutrition
  [
    'id' => 11,
    'cat' => 'nutrition',
    'title' => 'Breastfeeding Nutrition Can Be Confusing',
    'author' => 'Mayo Clinic (2025)',
    'thumb' => 'public/images/articles/thumbs/unicef.jpg',
    'overview' => 'Explains basic nutrition needs, extra calories, and hydration for breastfeeding mothers.',
    'link' => 'https://www.mayoclinic.org/healthy-lifestyle/infant-and-toddler-health/in-depth/breastfeeding-nutrition/art-20046912',
  ],

  [
    'id' => 12,
    'cat' => 'nutrition',
    'title' => 'Smart Food Choices',
    'author' => 'Intermountain Healthcare (2023)',
    'thumb' => 'public/images/articles/thumbs/unicef.jpg',
    'overview' => 'Encourages eating fruits, vegetables, whole grains, and lean protein to support milk production.',
    'link' => 'https://intermountainhealthcare.org/blogs/article/proper-nutrition-while-breastfeeding',
  ],

  [
    'id' => 13,
    'cat' => 'nutrition',
    'title' => 'Mums Don’t Need a Perfect Diet – Here’s What Really Matters',
    'author' => 'Australian Breastfeeding Association (2025)',
    'thumb' => 'public/images/articles/thumbs/unicef.jpg',
    'overview' => 'States that a balanced and varied diet is enough—perfection is not required',
    'link' => 'https://www.breastfeeding.asn.au/resources/breastfeeding-your-diet',
  ],

  [
    'id' => 14,
    'cat' => 'nutrition',
    'title' => 'Foods to Eat and Avoid While Breastfeeding ',
    'author' => 'Zawn Villines (2023)',
    'thumb' => 'public/images/articles/thumbs/unicef.jpg',
    'overview' => 'Lists healthy food options and advises eliminating caffeine and alcohol.',
    'link' => 'https://www.medicalnewstoday.com/articles/322844',
  ],

  [
    'id' => 15,
    'cat' => 'nutrition',
    'title' => 'Essential Nutrients That I Will Need as a Breastfeeding Mother',
    'author' => 'Health Promotion Board (2023)',
    'thumb' => 'public/images/articles/thumbs/unicef.jpg',
    'overview' => 'Highlights key nutrients like calcium, iron, iodine, and omega-3.',
    'link' => 'https://www.healthhub.sg/well-being-and-lifestyle/pregnancy-and-infant-health/what-to-eat-while-breastfeeding',
  ],

  [
    'id' => 16,
    'cat' => 'nutrition',
    'title' => 'Can I Eat That? I’m Breastfeeding ',
    'author' => 'Poonam Sachdev (2024)',
    'thumb' => 'public/images/articles/thumbs/unicef.jpg',
    'overview' => 'Answers common questions about safe and unsafe foods while breastfeeding.',
    'link' => 'https://www.webmd.com/parenting/baby/ss/slideshow-breastfeeding-foods',
  ],

  // tips
  [
    'id' => 17,
    'cat' => 'tips',
    'title' => 'Breastfeeding Beginner Tips ',
    'author' => 'Diane L. Spatz',
    'thumb' => 'public/images/articles/thumbs/unicef.jpg',
    'overview' => 'Provides simple guidance for new mothers on proper latch, positioning, and early breastfeeding support to ensure success.',
    'link' => 'https://www.chop.edu/centers-programs/breastfeeding-and-lactation-program/breastfeeding-tips-beginners',
  ],
  [
    'id' => 18,
    'cat' => 'tips',
    'title' => 'Benefits of Breastfeeding ',
    'author' => 'S. Kam Lam (2023)',
    'thumb' => 'public/images/articles/thumbs/unicef.jpg',
    'overview' => 'Explains the health benefits of breastfeeding, including stronger immunity for babies and reduced health risks for mothers.',
    'link' => 'https://my.clevelandclinic.org/health/articles/15274-benefits-of-breastfeeding',
  ],
  [
    'id' => 19,
    'cat' => 'tips',
    'title' => 'Breastmilk is the Bestmilk',
    'author' => 'Rachel Nelson (2015)',
    'thumb' => 'public/images/articles/thumbs/unicef.jpg',
    'overview' => 'Highlights that breast milk is the best nutrition for infants, supporting growth, bonding, and long-term health.',
    'link' => 'https://lifeandhealth.org/lifestyle/3959/163959.html?gad_source=1&gad_campaignid=22424464928&gbraid=0AAAAAC7gUNcPiB9IU-N-44jjXtwCtkkvB&gclid=Cj0KCQiA18DMBhDeARIsABtYwT15PeWd0y5hhEWGE6sQ_UzA0LF4Q3tz1Hw9puG544dMd2FU1kAeBdEaAuXREALw_wcB',
  ],
  [
    'id' => 20,
    'cat' => 'tips',
    'title' => 'Importance of Breastfeeding',
    'author' => ' Paul Jaysent F. Fos (2024)',
    'thumb' => 'public/images/articles/thumbs/unicef.jpg',
    'overview' => 'Emphasizes breastfeeding’s role in improving maternal and child health and promoting public health overall.',
    'link' => 'https://pia.gov.ph/news/doh-reminds-mothers-of-the-importance-of-breastfeeding/',
  ],
  // la
  [
    'id' => 21,
    'cat' => 'la',
    'title' => 'Breastfeeding Position',
    'author' => 'Author: Mayo Clinic. (2024). ',
    'thumb' => 'public/images/articles/thumbs/unicef.jpg',
    'overview' => 'Breastfeeding Position helps mother and infants for effective and comfortable breastfeeding, such as cradle position that good for baby in any age; cross-cradle position is best for newborn that allows you control the infants head; laid back position works well with small breast; side laying position is good choice when you are resting and football position is best for C-Section mother.',
    'link' => 'https://www.mayoclinic.org/healthy-lifestyle/infant-and-toddler-health/in-depth/breast-feeding/art-20546815',
  ],
  [
    'id' => 22,
    'cat' => 'la',
    'title' => 'Common Breastfeeding Positions',
    'author' => 'UNICEF. (2023)',
    'thumb' => 'public/images/articles/thumbs/unicef.jpg',
    'overview' => 'Tips and Position that helps mother for effective breastfeeding. The tips greatly help the mother to understand that infants are well-feed with proper latching, good positioning and effective suckling.',
    'link' => 'https://www.unicef.org/parenting/food-nutrition/breastfeeding-positions',
  ],
  [
    'id' => 23,
    'cat' => 'la',
    'title' => 'Common Breastfeeding Positions',
    'author' => 'UNICEF. (2023).',
    'thumb' => 'public/images/articles/thumbs/unicef.jpg',
    'overview' => 'Aside from usual and common positions, it presented additional and more breastfeeding positions, these positions vary on how they are being and some are used for special circumstances.',
    'link' => 'https://www.medela.com/en/breastfeeding-pumping/articles/breastfeeding-tips/11-different-breastfeeding-positions',
  ],
  [
    'id' => 24,
    'cat' => 'la',
    'title' => 'The First Week: Positioning and Latch',
    'author' => 'La Leche League International. (2023). ',
    'thumb' => 'public/images/articles/thumbs/unicef.jpg',
    'overview' => 'Highlights the importance of position and latching for a newborn.',
    'link' => 'https://llli.org/breastfeeding-info/positioning/',
  ],
];
