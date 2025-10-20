INSERT INTO public.categories (nom_categorie) VALUES
('Maçonnerie'),
('Jardinage'),
('Électricité'),
('Menuiserie'),
('Plomberie');

INSERT INTO public.outils (id_categorie, nom, description, prix_journalier, image_url, stock) VALUES
-- Maçonnerie (ID 1)
((SELECT id_categorie FROM categories WHERE nom_categorie = 'Maçonnerie'), 'Bétonnière 180L', 'Mélangeur professionnel pour ciment et mortier.', 35.00, 'img/betonniere.jpg', 2),
((SELECT id_categorie FROM categories WHERE nom_categorie = 'Maçonnerie'), 'Marteau-piqueur 10kg', 'Démolisseur puissant pour dalles et murs.', 45.00, 'img/marteau-piqueur.jpg', 3),
((SELECT id_categorie FROM categories WHERE nom_categorie = 'Maçonnerie'), 'Carotteuse Diamant', 'Machine pour percer des trous dans le béton armé.', 60.00, 'img/carotteuse.jpg', 4),
((SELECT id_categorie FROM categories WHERE nom_categorie = 'Maçonnerie'), 'Niveau Laser Rotatif', 'Niveau automatique pour travaux de grande envergure.', 25.00, 'img/niveau-laser.jpg', 3),
-- Jardinage (ID 2)
((SELECT id_categorie FROM categories WHERE nom_categorie = 'Jardinage'), 'Tondeuse Autoportée', 'Tondeuse pour grands terrains, largeur de coupe 100cm.', 75.00, 'img/tondeuse-autoportee.jpg', 5),
((SELECT id_categorie FROM categories WHERE nom_categorie = 'Jardinage'), 'Motoculteur 7CV', 'Pour retourner et préparer la terre avant plantation.', 40.00, 'img/motoculteur.jpg', 5),
((SELECT id_categorie FROM categories WHERE nom_categorie = 'Jardinage'), 'Taille-haie Télescopique', 'Pour couper les haies en hauteur sans échelle.', 18.50, 'img/taille-haie.jpg', 8),
((SELECT id_categorie FROM categories WHERE nom_categorie = 'Jardinage'), 'Débroussailleuse Pro', 'Pour nettoyer les terrains encombrés de broussailles.', 30.00, 'img/debroussailleuse.jpg', 10),
-- Électricité (ID 3)
((SELECT id_categorie FROM categories WHERE nom_categorie = 'Électricité'), 'Générateur Électrique 3kW', 'Source d''alimentation portable pour chantiers.', 55.00, 'img/generateur.jpg', 4),
((SELECT id_categorie FROM categories WHERE nom_categorie = 'Électricité'), 'Testeur de Câbles RJ45', 'Pour vérifier la continuité des réseaux informatiques.', 8.00, 'img/testeur-rj45.jpg', 15),
((SELECT id_categorie FROM categories WHERE nom_categorie = 'Électricité'), 'Pince à Sertir Hydraulique', 'Pour cosses électriques de gros diamètre.', 22.00, 'img/pince-sertir.jpg', 15),
((SELECT id_categorie FROM categories WHERE nom_categorie = 'Électricité'), 'Thermomètre Infrarouge', 'Pour la détection de points chauds et froids.', 15.00, 'img/thermo-ir.jpg', 15),
-- Menuiserie (ID 4)
((SELECT id_categorie FROM categories WHERE nom_categorie = 'Menuiserie'), 'Scie Circulaire Plongeante', 'Pour coupes précises dans panneaux et bois massifs.', 28.50, 'img/scie-plongeante.jpg', 5),
((SELECT id_categorie FROM categories WHERE nom_categorie = 'Menuiserie'), 'Ponceuse à Bande Pro', 'Pour le ponçage rapide de grandes surfaces en bois.', 20.00, 'img/ponceuse-bande.jpg', 7),
((SELECT id_categorie FROM categories WHERE nom_categorie = 'Menuiserie'), 'Cloueur Pneumatique', 'Pour l''assemblage rapide de charpentes et planchers.', 33.00, 'img/cloueur.jpg', 5),
((SELECT id_categorie FROM categories WHERE nom_categorie = 'Menuiserie'), 'Raboteuse-Dégauchisseuse', 'Machine pour mettre le bois d''équerre.', 70.00, 'img/raboteuse.jpg', 6),
-- Plomberie (ID 5)
((SELECT id_categorie FROM categories WHERE nom_categorie = 'Plomberie'), 'Caméra d''Inspection 20m', 'Pour visualiser l''intérieur des canalisations.', 40.50, 'img/camera-plomberie.jpg', 5),
((SELECT id_categorie FROM categories WHERE nom_categorie = 'Plomberie'), 'Soudeuse PVC Électrique', 'Pour l''assemblage par fusion de tubes plastiques.', 24.00, 'img/soudeuse-pvc.jpg', 10),
((SELECT id_categorie FROM categories WHERE nom_categorie = 'Plomberie'), 'Furet Électrique', 'Pour déboucher les canalisations fortement obstruées.', 38.00, 'img/furet-electrique.jpg', 15),
((SELECT id_categorie FROM categories WHERE nom_categorie = 'Plomberie'), 'Pince à Sertir Multicouche', 'Pour la pose de raccords multicouches.', 26.00, 'img/pince-multicouche.jpg', 15);