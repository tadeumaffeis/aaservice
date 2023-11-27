#include <iostream>

extern void printArray(int arr[], int size);

void insertionSort(int arr[], int n) {
    for (int i = 1; i < n; i++) {
        int chave = arr[i];
        int j = i - 1;

        // Move os elementos do subarray ordenado para a frente
        // até encontrar a posição correta para a chave
        while (j >= 0 && arr[j] > chave) {
            arr[j + 1] = arr[j];
            printArray(arr, n);
            j = j - 1;
        }

        arr[j + 1] = chave;
        printArray(arr, n);
    }
}
