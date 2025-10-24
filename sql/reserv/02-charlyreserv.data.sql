INSERT INTO public.reservations (id_reservation, id_utilisateur, statut, prix_total) VALUES
('a41ccf5c-9365-4232-a6e7-9b62740b60e6', 'fbdb2514-4caf-4864-afca-89b565f5eece', 'Validé', 175.00),
('f30cdbf8-0412-4dd5-a439-b8c173bf11cc', 'fbdb2514-4caf-4864-afca-89b565f5eece', 'En Attente', 0.00),
('8a2f1c3d-9d4b-4f7a-b2c0-1a2b3c4d5e6f', 'fbdb2514-4caf-4864-afca-89b565f5eece', 'Terminé', 105.00),
('b7c3d2e1-2f4a-438b-a6b9-0f1e2d3c4b5a', 'fbdb2514-4caf-4864-afca-89b565f5eece', 'En Attente', 0.00),
('c1d2e3f4-1234-4abc-9def-0123456789ab', 'fbdb2514-4caf-4864-afca-89b565f5eece', 'Terminé', 245.00);

INSERT INTO public.reservation_outils (id_reservation, id_outil,  date_debut, date_fin) VALUES
('a41ccf5c-9365-4232-a6e7-9b62740b60e6', '2cd179a8-d38d-441e-a31b-d88a6611cea1', '2025-10-01', '2025-10-05'),
('a41ccf5c-9365-4232-a6e7-9b62740b60e6', '0d13b42e-c5e4-4df1-bd7f-94dd71879f54', '2025-10-02', '2025-10-02'),
('f30cdbf8-0412-4dd5-a439-b8c173bf11cc', '19ff8036-6f39-4414-a70e-043684b7e7ef', '2025-10-02', '2025-10-10'),
('8a2f1c3d-9d4b-4f7a-b2c0-1a2b3c4d5e6f', '7cc2c89b-50c4-41a1-9ba3-8cb7bb49ee34', '2025-09-15', '2025-09-17'),
('8a2f1c3d-9d4b-4f7a-b2c0-1a2b3c4d5e6f', 'e2e48724-5e0f-49a6-ba50-e12d975c396f', '2025-09-16', '2025-09-16'),
('b7c3d2e1-2f4a-438b-a6b9-0f1e2d3c4b5a', 'd4eb93d9-2d59-4fdc-90cf-42eeb2d2cca6', '2025-10-05', '2025-10-12'),
('c1d2e3f4-1234-4abc-9def-0123456789ab', '0652ec54-022a-45ed-8f2a-efbb29c728a0', '2025-08-20', '2025-08-25'),
('c1d2e3f4-1234-4abc-9def-0123456789ab', '3efdba80-c65d-418f-86f2-923931eb5263', '2025-08-21', '2025-08-23'),
('c1d2e3f4-1234-4abc-9def-0123456789ab', '7d1f1242-c039-4ed1-bb32-d15d8f0bc50d', '2025-08-22', '2025-08-24');