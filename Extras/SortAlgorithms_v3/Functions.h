//#define _DEBUG_
//#define _QUICKSORT_
//#define _HEAPSORT_
//#define _BUBBLESORT_
//#define _SELECTIONSORT_
//#define _INSERTIONSORT_
#define _MINMAXSORT_
//#define _RELOAD_

extern void HeapSort(long vet[], long heapsize);
extern void QuickSort(long vet[], long began, long end, long size);
extern void BubbleSort(long vet[], long size);
extern void SelectionSort(long vet[], long size);
extern void InsertionSort(long vet[], long size);
extern void MinMaxSort(long vet[], long size);
extern void swap(long vet[], long a, long b);
extern void loadRandValues(long vet[], long size, long limit);
extern void show(long vet[], long size);
extern void show_color(long vet[], long size, long x, long y);
extern void ShowLine(long vet[], long size);




