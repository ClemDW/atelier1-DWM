INSERT INTO public.reservations (id_reservation, id_utilisateur, date_debut, date_fin, statut, prix_total) VALUES
('a41ccf5c-9365-4232-a6e7-9b62740b60e6', 'fbdb2514-4caf-4864-afca-89b565f5eece', '2025-10-01', '2025-10-05', 'Validé', 175.00),
('f30cdbf8-0412-4dd5-a439-b8c173bf11cc', 'fbdb2514-4caf-4864-afca-89b565f5eece', '2025-10-02', '2025-10-02', 'En Attente', 0.00)

INSERT INTO public.reservation_outils (id_reservation, id_outil, quantite) VALUES
+('a41ccf5c-9365-4232-a6e7-9b62740b60e6', 1, 1),
+('a41ccf5c-9365-4232-a6e7-9b62740b60e6', 2, 1),
+('f30cdbf8-0412-4dd5-a439-b8c173bf11cc', 3, 1);